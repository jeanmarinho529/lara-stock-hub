<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProduct extends Component
{
    use WithPagination;

    public User $user;

    public string $filter = '';

    public string $type = '';

    protected $queryString = ['filter', 'type'];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $products = Product::select(
            'id',
            'brand_id',
            'name',
            'code',
            'amount',
            'type'
        )
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->when($this->filter, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->filter}%")
                        ->orWhere('code', 'like', "%{$this->filter}%");
                });
            })
            ->with('brand:id,name')
            ->withSum(['productTransactions as product_transactions_sum_quantity_store' => function ($query) {
                $query->where('local', 'store');
            }], 'quantity')
            ->withSum(['productTransactions as product_transactions_sum_quantity_others' => function ($query) {
                $query->whereIn('local', ['stock', 'others']);
            }], 'quantity')
            ->where('store_id', $this->user->store_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.products.index-product', [
            'products' => $products,
        ]);
    }
}
