<?php
namespace App\Livewire\Brands;

use Livewire\Component;
use App\Models\Brand;
use App\Models\Store;

class UpdateBrand extends Component
{
    public $brand;
    public $name;
    public $store_id;
    public $stores;

    public function mount($id)
    {
        
        $this->brand = Brand::findOrFail($id);
        $this->name = $this->brand->name;
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|min:3',
        ]);

        $this->brand->update([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Marca atualizada com sucesso!');
        

        return redirect()->route('brands.index');
    }

    public function render()
    {
        return view('livewire.brands.update-brand');
    }
}
