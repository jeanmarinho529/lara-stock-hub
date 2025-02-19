<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateBrand extends Component
{
    public Brand $brand;

    #[Validate('required|string|min:3')]
    public string $name;

    public function mount(string $id)
    {
        $user        = Auth::user();
        $this->brand = Brand::where('store_id', $user->store_id)->findOrFail($id);
        $this->name  = $this->brand->name;
    }

    public function save()
    {
        $this->validate();

        $this->brand->update([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Marca atualizada com sucesso!');

        redirect()->route('brands.index');
    }

    public function render()
    {
        return view('livewire.brands.update-brand');
    }
}
