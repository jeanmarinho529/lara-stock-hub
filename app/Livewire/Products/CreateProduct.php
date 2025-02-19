<?php

namespace App\Livewire\Products;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProduct extends Component
{
    public User $user;

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

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function save()
    {
        $this->validate();

        try {
            Product::create([
                'brand_id'         => $this->brand_id,
                'store_id'         => $this->user->store_id,
                'user_id'          => $this->user->id,
                'name'             => $this->name,
                'code'             => $this->code,
                'type'             => $this->type,
                'amount'           => $this->amount,
                'minimum_quantity' => $this->minimum_quantity,
                'unit_measurement' => $this->unit_measurement,
                'description'      => $this->description,
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('waring', 'Código já cadastrado em outro produto, insira outro código!');

                return;
            }

            throw $e;
        }

        session()->flash('success', 'Produto cadastrado com sucesso.');
        redirect()->route('products.index');
    }

    public function render()
    {
        $brands = Brand::where('store_id', $this->user->store_id)->get()->toArray();

        return view('livewire.products.create-product', [
            'brands' => $brands,
        ]);
    }
}
