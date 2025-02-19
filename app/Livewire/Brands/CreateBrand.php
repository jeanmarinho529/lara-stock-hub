<?php

namespace App\Livewire\Brands;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use App\Models\Brand;
use App\Models\Store; 

class CreateBrand extends Component
{
    public $name;


    protected $rules = [
        'name' => 'required|min:3',
    ];


    public function submit()
    {
        $this->validate();

 
        Brand::create([
            'name' => $this->name,
            'store_id'      => Auth::user()->store_id,
        ]);

        session()->flash('message', 'Marca criada com sucesso!');
        return redirect()->route('brands.index');
    }


    public function render()
    {

        return view('livewire.brands.create-brand',);
    }
}
