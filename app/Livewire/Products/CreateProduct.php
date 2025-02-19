<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProduct extends Component
{
    #[Validate('required|string|min:4')]
    public string $name;

    #[Validate('required|string|in:product,service')]
    public string $type = 'product';

    public function save()
    {
        $this->validate();

        $products = Product::firstOrCreate(
            [
                'store_id'      => Auth::user()->store_id,
                'code'          => $this->code,
                'document_type' => $this->document_type,
            ],
        );

        redirect()->route('orders.create', ['client' => $products]);
    }

    public function render()
    {
        return view('livewire.products.create-product');
    }
}
