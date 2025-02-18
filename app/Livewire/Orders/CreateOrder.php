<?php

namespace App\Livewire\Orders;

use App\Livewire\Forms\ClientForm;
use App\Livewire\Forms\OrderForm;
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

class CreateOrder extends Component
{
    public Client $client;

    public ClientForm $clientForm;

    public OrderForm $order;

    public User $user;

    public array $products;

    public array $selectedProducts = [];

    public float $total = 0;

    public string $paymentMethod = '';

    public int $installments = 1;

    public float $discount = 0;

    public string $discountType = 'percentage';

    public float $amountReceived = 0;

    public bool $saleMade = false;

    public string $searchTerm = '';

    public array $productDefaults = [];

    public function mount(Client $client)
    {
        $this->user = Auth::user();

        $this->clientForm->setClient($client);

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

    public function addItem($item): void
    {
        if (array_key_exists($item['code'], $this->selectedProducts)) {
            $this->selectedProducts[$item['code']]['quantity'] += 1;
            $this->calculateTotalItem($item['code']);

            return;
        }

        $item['quantity']                      = 1;
        $item['total']                         = $item['amount'];
        $this->selectedProducts[$item['code']] = $item;

        $this->calculateTotal();
    }

    public function removeItem($code): void
    {
        unset($this->selectedProducts[$code]);
        $this->calculateTotal();
    }

    public function calculateTotalItem($code)
    {
        $this->selectedProducts[$code]['total'] = $this->selectedProducts[$code]['quantity'] * $this->selectedProducts[$code]['amount'];
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;

        foreach ($this->selectedProducts as $item) {
            $this->total += $item['total'];
        }

        $this->calculateAmountReceived();
    }

    public function calculateAmountReceived()
    {
        if ($this->discountType == 'percentage' and $this->discount > 0) {
            $this->amountReceived = $this->total * (1 - $this->discount / 100);
        } else {
            $this->amountReceived = $this->total - $this->discount;
        }

        $this->amountReceived = round($this->amountReceived, 2);
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

        $this->calculateAmountReceived();

        $paymentMethodConfigs = PaymentMethodConfig::where('type', 'receivable')
            ->where('payment_method', $this->paymentMethod)
            ->where('store_id', $this->user->store_id)
            ->get();

        try {
            DB::transaction(function () use ($paymentMethodConfigs) {
                $order = Order::create([
                    'client_id'       => $this->client->id,
                    'store_id'        => $this->user->store_id,
                    'user_id'         => $this->user->id,
                    'payment_method'  => $this->paymentMethod,
                    'installments'    => $this->installments,
                    'amount'          => $this->total,
                    'amount_received' => $this->amountReceived,
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
            $amount                   = $this->amountReceived / $this->installments;
            $transactionEffectiveDate = $paymentMethodConfig->transaction_effective_date ?? 0;

            FinancialTransaction::create([
                'client_id'            => $this->client->id,
                'create_by_user_id'    => $this->user->id,
                'store_id'             => $this->user->store_id,
                'order_id'             => $orderId,
                'type'                 => 'receivable',
                'payment_method'       => $this->paymentMethod,
                'amount'               => $amount,
                'amount_paid'          => $transactionEffectiveDate ? 0 : $amount,
                'status'               => $transactionEffectiveDate ? 'created' : 'done',
                'payment_estimate_at'  => now()->addDays($transactionEffectiveDate),
                'status_changed_at'    => now(),
                'payment_completed_at' => $transactionEffectiveDate ? null : now(),
                'description'          => "Valor a receber de R$ {$amount} / R$ {$this->amountReceived} da venda {$orderId} - Parcela {$installment}/{$this->installments}",
            ]);
        }
    }

    public function updatedSearchTerm($term)
    {
        $this->products = [];

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

        // $this->products = $this->productDefaults;
    }
}
