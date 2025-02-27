<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\User;
use App\Services\ProductTransactionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProductTransaction extends Component
{
    public User $user;

    public string $productId;

    public string $productName;

    public string $productCode;

    public string $brandName;

    public array $products = [];

    public array $productDefaults = [];

    public string $searchTerm = '';

    public array $productTransactions = [];

    #[Validate('required|string')]
    public string $product;

    #[Validate('required|integer|min:0.01')]
    public int $quantity = 1;

    #[Validate('required|string|in:added,removed,transferred')]
    public string $type = '';

    #[Validate('required|string|in:store,stock,others')]
    public string $local = '';

    #[Validate('string|nullable|required_if:type,transferred|in:store,stock,others')]
    public string $local_transfer = '';

    public function mount()
    {
        $this->user = Auth::user();

        $this->productDefaults = Product::where('type', 'product')->searchByName($this->user->store_id)
            ->limit(10)
            ->get()
            ->toArray();

        $this->products = $this->productDefaults;
    }

    public function render()
    {
        return view('livewire.products.create-product-transaction');
    }

    public function save()
    {
        $this->validate();

        if ($this->type == 'transferred' and $this->local == $this->local_transfer) {
            session()->flash('waring', 'Você não pode transferir o produto para o mesmo destino!');

            return;
        }

        if ($this->user->role == 'seller' & $this->type != 'transferred') {
            session()->flash('waring', 'Você não tem permissão para adicionar ou remover produtos!');

            return;
        }

        if (in_array($this->type, ['removed', 'transferred'])) {
            $totalQuantity = ProductTransaction::where('product_id', $this->productId)
                ->where('local', $this->local)
                ->sum('quantity');

            if ($this->quantity > $totalQuantity) {
                session()->flash('waring', 'Esse produto não possui quantidade suficiente!');

                return;
            }
        }

        $this->createProductTransaction($this->type);
    }

    public function createProductTransaction(string $type)
    {
        $service = new ProductTransactionService();
        $service->createProductTransaction(
            $this->productId,
            $this->quantity,
            $this->type,
            $this->local,
            0,
            null,
            $this->local_transfer,
            $this->user
        );

        $types = [
            'added'       => 'Adicionado',
            'removed'     => 'Removido',
            'transferred' => 'Transferido',
        ];

        $this->productTransactions[] = [
            'display_created_at' => now()->format('d/m/y H:i:s'),
            'display_type'       => $types[$type],
            'quantity'           => $this->quantity,
            'user'               => [
                'name' => $this->user->name,
            ],
            'product' => [
                'id'    => $this->productId,
                'name'  => $this->productName,
                'code'  => $this->productCode,
                'brand' => [
                    'name' => $this->brandName,
                ],
            ],
        ];
    }

    public function addProduct($product)
    {
        $this->product     = $product['brand']['name'] . ' - ' . $product['name'] . ' - ' . $product['code'];
        $this->productName = $product['name'];
        $this->productCode = $product['code'];
        $this->brandName   = $product['brand']['name'];
        $this->productId   = $product['id'];
    }

    public function updatedSearchTerm($term)
    {
        $this->products = [];

        if (strlen($term) == 0) {
            $this->products = $this->productDefaults;

            return;
        }

        $this->products = Product::where('type', 'product')->searchByCode($this->user->store_id, $term)
            ->limit(10)
            ->get()
            ->toArray();

        if (count($this->products) == 1) {
            $this->addProduct($this->products[0]);
            $this->searchTerm = '';
        }

        if (count($this->products) == 0) {
            $this->products = Product::where('type', 'product')->searchByName($this->user->store_id, $term)
                ->limit(10)
                ->get()
                ->toArray();
        }
    }
}
