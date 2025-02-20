<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateBrand extends Component
{
    #[Validate('required|string|min:4')]
    public string $name;

    public function save()
    {
        $this->validate();

        try {
            Brand::create([
                'name'     => trim($this->name),
                'store_id' => Auth::user()->store_id,
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('waring', 'Marca já cadastrado, insira outro nome!');

                return;
            }

            throw $e;
        }

        session()->flash('success', 'Marca cadastrada com sucesso.');
        redirect()->route('brands.index');
    }

    public function render()
    {
        return view('livewire.brands.create-brand');
    }
}
