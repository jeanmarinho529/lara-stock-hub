<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexClient extends Component
{
    use WithPagination;

    public User $user;

    public string $filter = "";

    protected $queryString = ['filter'];

    public ?int $clientDefaultId;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $this->clientDefaultId = Client::where('store_id', $this->user->store_id)
            ->where('email', 'client@default.com')
            ->first()->id ?? null;

        $clients = Client::where('store_id', $this->user->store_id)
            ->when($this->filter, function ($query) {
                return $query->where('name', 'like', "%$this->filter%")
                    ->orWhere('document', 'like', "%$this->filter%")
                    ->orWhere('email', 'like', "%$this->filter%")
                    ->orWhere('cell_number', 'like', "%$this->filter%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.clients.index-client', [
            'clients' => $clients,
        ]);
    }
}
