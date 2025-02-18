<?php

namespace App\Livewire\Orders;

use App\Models\Client;
use App\Models\FinancialTransaction;
use App\Models\Order;
use App\Models\PaymentMethodConfig;
use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreateOrder extends Component
{
    public User $user;

    # request client 
    #[Validate('required|string|numeric')]
    public string $client_id;

    #[Validate('required|string')]
    public string $client_name;

    #[Validate('required|string')]
    public string $client_document;

    #[Validate('required|string')]
    public string $client_cell_number;

    # request order
    #[Validate('required|numeric|min:0')]
    public float $total = 0;

    #[Validate('required|string|in:cash,pix,credit_card,bank_slip,bank_transfer')]
    public string $payment_method = '';

    #[Validate('required|integer|min:1')]
    public int $installments = 1;

    #[Validate('required|numeric|min:0')]
    public float $discount = 0;

    #[Validate('required|string|in:percentage,absolute_value')]
    public string $discount_type = 'percentage';

    #[Validate('required|numeric|min:0')]
    public float $amount_received = 0;

    public array $products;

    public array $productDefaults = [];

    public array $selectedProducts = [];

    public bool $saleMade = false;

    public string $searchTerm = '';


    public function mount(Client $client)
    {
        $this->user = Auth::user();

        $this->client_id = $client->id;
        $this->client_name = $client->name;
        $this->client_document = $client->document;
        $this->client_cell_number = $client->cell_number;

        $this->productDefaults = Product::searchByName($this->user->store_id)
            ->limit(10)
            ->get()
            ->toArray();

        $this->products = $this->productDefaults;
    }

    public function render()
    {
        return view('livewire.orders.create-order');
    }

    public function addProduct($item): void
    {
        if (array_key_exists($item['code'], $this->selectedProducts)) {
            $this->selectedProducts[$item['code']]['quantity'] += 1;
            $this->calculateTotalProduct($item['code']);

            return;
        }

        $item['quantity']                      = 1;
        $item['total']                         = $item['amount'];
        $this->selectedProducts[$item['code']] = $item;

        $this->calculateTotal();
    }

    public function removeProduct($code): void
    {
        unset($this->selectedProducts[$code]);
        $this->calculateTotal();
    }

    public function calculateTotalProduct($code): void
    {
        $this->selectedProducts[$code]['total'] = $this->selectedProducts[$code]['quantity'] * $this->selectedProducts[$code]['amount'];
        $this->calculateTotal();
    }

    public function calculateTotal(): void
    {
        $this->total = 0;

        foreach ($this->selectedProducts as $item) {
            $this->total += $item['total'];
        }

        $this->calculateAmountReceived();
    }

    public function calculateAmountReceived(): void
    {
        if ($this->discount_type == 'percentage' and $this->discount > 0) {
            $this->amount_received = $this->total * (1 - $this->discount / 100);
        } else {
            $this->amount_received = $this->total - $this->discount;
        }

        $this->amount_received = round($this->amount_received, 2);
    }

    public function save()
    {
        if ($this->saleMade) {
            session()->flash('waring', 'Venda já realizada.');

            return;
        }

        if (count($this->selectedProducts) == 0) {
            session()->flash('waring', 'Você precisa selecionar os produtos para realizar a venda.');

            return;
        }

        $paymentMethodConfigs = PaymentMethodConfig::where('type', 'receivable')
            ->where('payment_method', $this->payment_method)
            ->where('store_id', $this->user->store_id)
            ->get();

        try {
            $this->validate();

            DB::transaction(function () use ($paymentMethodConfigs) {
                $order = Order::create([
                    'client_id'       => $this->client_id,
                    'store_id'        => $this->user->store_id,
                    'user_id'         => $this->user->id,
                    'payment_method'  => $this->payment_method,
                    'installments'    => $this->installments,
                    'amount'          => $this->total,
                    'amount_received' => $this->amount_received,
                ]);

                foreach ($this->selectedProducts as $selectedItem) {
                    ProductTransaction::create([
                        'product_id' => $selectedItem['id'],
                        'order_id'   => $order->id,
                        'user_id'    => $this->user->id,
                        'quantity'   => $selectedItem['quantity'],
                        'type'       => 'sold',
                        'local'      => 'stock',
                        'amount'     => $selectedItem['amount'],
                    ]);
                }

                $this->createTransaction($paymentMethodConfigs, $order->id);

                $this->saleMade = true;
                session()->flash('success', 'Venda realizada com sucesso.');
            }, 5);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function createTransaction($paymentMethodConfigs, $orderId)
    {
        foreach (range(1, $this->installments) as $installment) {
            $paymentMethodConfig      = $paymentMethodConfigs->where('installments', $installment)->first();
            $amount                   = $this->amount_received / $this->installments;
            $transactionEffectiveDate = $paymentMethodConfig->transaction_effective_date ?? 0;

            FinancialTransaction::create([
                'client_id'            => $this->client_id,
                'create_by_user_id'    => $this->user->id,
                'store_id'             => $this->user->store_id,
                'order_id'             => $orderId,
                'type'                 => 'receivable',
                'payment_method'       => $this->payment_method,
                'amount'               => $amount,
                'amount_paid'          => $transactionEffectiveDate ? 0 : $amount,
                'status'               => $transactionEffectiveDate ? 'created' : 'done',
                'payment_estimate_at'  => now()->addDays($transactionEffectiveDate),
                'status_changed_at'    => now(),
                'payment_completed_at' => $transactionEffectiveDate ? null : now(),
                'description'          => "Valor a receber de R$ {$amount} / R$ {$this->amount_received} da venda {$orderId} - Parcela {$installment}/{$this->installments}",
            ]);
        }
    }

    public function updatedSearchTerm($term)
    {
        $this->products = [];

        if (strlen($term) == 0) {
            $this->products = $this->productDefaults;
            return;
        }

        if (strlen($term) < 3) {
            return;
        }

        $this->products = Product::searchByCode($this->user->store_id, $term)
            ->limit(1)
            ->get()
            ->toArray();

        if (count($this->products) == 1) {
            $this->addItem($this->products[0]);
            $this->searchTerm = '';
        }

        if (count($this->products) == 0) {
            $this->products = Product::searchByName($this->user->store_id, $term)
                ->limit(10)
                ->get()
                ->toArray();
        }
    }
}
