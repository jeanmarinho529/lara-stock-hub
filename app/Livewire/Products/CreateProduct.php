<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProduct extends Component
{
    #[Validate('required|string|min:4')]
    public string $name;

    #[Validate('required|string|min:5')]
    public string $code;

    #[Validate('required|numeric|min:0.01')]
    public float $amount;

    #[Validate('required|integer|min:0')]
    public int $minimun_quantity = 1;

    #[Validate('nullable|string|min:1')]
    public string $description;

    #[Validate('required|string|in:product,service')]
    public string $type = 'product';
    
    #[Validate('string|required_if:type,product')]
    public ?string $brand_id = '';


    public function save()
    {
        $this->validate();

        $products = Product::firstOrCreate(
            [
                'user_id'  => Auth::user()->id,
                'store_id' => Auth::user()->store_id,
                'brand_id' => $this->brand_id,
                'code'     => $this->code,
                'name'     => $this->name,
                'amount'   => $this->amount,
            ],
        );

        session()->flash('message', 'Produto "' . $this->name . '" criada com sucesso!');
        redirect()->route('products.index');
    }

    public function render()
    {
        {
            $brands = Brand::where('store_id', Auth::user()->store_id)->get()->toArray();
            

            return view('livewire.products.create-product', [
                'brands' => $brands,
            ]);
        }
    }
}
