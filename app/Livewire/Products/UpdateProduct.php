<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateProduct extends Component
{
    public User $user;

    public Product $product;

    #[Validate('string|nullable|required_if:type,product')]
    public ?string $brand_id = null;

    #[Validate('required|string|min:4')]
    public string $name;

    #[Validate('required|string|min:5')]
    public string $code;

    #[Validate('required|numeric|min:0.01')]
    public float $amount;

    #[Validate('required|integer|min:0')]
    public int $minimum_quantity = 1;

    #[Validate('required|string|in:unit,centimeter,meter,gram,kilogram,liter,milliliter')]
    public string $unit_measurement = 'unit';

    #[Validate('required|string|in:product,service')]
    public string $type = '';

    #[Validate('nullable|string|min:4')]
    public string $description = '';

    public function mount($productId)
    {
        $this->user    = Auth::user();
        $this->product = Product::where('store_id', $this->user->store_id)->findOrFail($productId);

        $this->brand_id         = $this->product->id;
        $this->brand_id         = $this->product->brand_id;
        $this->name             = $this->product->name;
        $this->code             = $this->product->code;
        $this->amount           = $this->product->amount;
        $this->minimum_quantity = $this->product->minimum_quantity;
        $this->unit_measurement = $this->product->unit_measurement;
        $this->type             = $this->product->type;
        $this->description      = $this->product->description;
    }

    public function save()
    {
        $this->validate();

        try {
            Product::where('id', $this->product->id)->update($this->except('product', 'user'));
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('waring', 'Código já cadastrado em outro produto, insira outro código!');

                return;
            }

            throw $e;
        }

        session()->flash('success', 'Produto atualizado com sucesso.');
    }

    public function render()
    {
        $brands = Brand::where('store_id', $this->user->store_id)->get()->toArray();

        return view('livewire.products.update-product', [
            'brands' => $brands,
        ]);
    }
}
