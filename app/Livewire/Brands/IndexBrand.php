<?php

namespace App\Livewire\Brands;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexBrand extends Component
{
    use WithPagination;

    public User $user;

    public string $filter = "";

    protected $queryString = ['filter'];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $brands = Brand::when($this->filter, function ($query) {
            return $query->where('name', 'like', "%$this->filter%");
        })
            ->where('store_id', $this->user->store_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.brands.index-brand', [
            'brands' => $brands,
        ]);
    }
}
