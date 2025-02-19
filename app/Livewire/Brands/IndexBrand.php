<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use Livewire\Component;

class IndexBrand extends Component
{
    public string $filter = "";

    protected $queryString = ['filter'];

    public function render()
    {
        $brands = Brand::when($this->filter, function ($query) {
            return $query->where('name', 'like', "%$this->filter%");
        })
            ->paginate(10);

        return view('livewire.brands.index-brand', [
            'brands' => $brands,
        ]);
    }
}
