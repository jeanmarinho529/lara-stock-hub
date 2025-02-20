<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\ProductTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class IndexProductTransaction extends Component
{
    use WithPagination;

    public User $user;

    public ?string $productId = null;

    public ?string $productName = null;

    public string $filter = '';

    public string $type = '';

    public string $date = '';

    public string $sort = 'desc';

    protected $queryString = ['filter', 'type', 'date', 'sort'];

    public function mount(?string $productId = null)
    {
        $this->user = Auth::user();

        $this->productId = $productId;

        if ($productId) {
            $this->productName = Product::select(DB::raw("CONCAT(name, ' - ', code) AS name"))
                ->where('store_id', $this->user->store_id)
                ->findOrFail($productId)->name;
        }
    }

    public function render()
    {
        $productTransactions = ProductTransaction::select(
            'id',
            'user_id',
            'product_id',
            'quantity',
            'type',
            'created_at',
        )
            ->with(
                'user:id,name',
                'product:id,brand_id,name,code',
                'product.brand:id,name',
            )
            ->when($this->productId, function ($query) {
                return $query->where('product_id', $this->productId);
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })
            ->when($this->date, function ($query) {
                return $query->where('created_at', '>', $this->date)
                    ->where('created_at', '<=', "$this->date 23:59:59");
            })
            ->when($this->filter, function ($query) {
                return $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', "%$this->filter%")
                        ->orWhere('code', 'like', "%$this->filter%");
                });
            })
            ->orderBy('created_at', $this->sort)
            ->paginate(10);

        return view('livewire.products.index-product-transaction', [
            'productTransactions' => $productTransactions,
        ]);
    }
}
