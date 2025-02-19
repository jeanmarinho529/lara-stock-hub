<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateBrand extends Component
{
    #[Validate('required|string|min:4')]
    public string $name;

    public function submit()
    {      
        Brand::create([
            'name'     => $this->name,
            'store_id' => Auth::user()->store_id,
        ]);

        session()->flash('message', 'Marca "' . $this->name . '" criada com sucesso!');

        return redirect()->route('brands.index');
    }

    public function render()
    {
        return view('livewire.brands.create-brand');
    }
}
