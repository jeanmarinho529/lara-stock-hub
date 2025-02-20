<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateClient extends Component
{
    public Client $client;

    #[Validate('required|string|min:4')]
    public string $name;

    #[Validate('required|string|min:11')]
    public string $document;

    #[Validate('required|string|in:cpf,cnpj')]
    public string $document_type = 'cpf';

    #[Validate('required|string|in:client,supplier')]
    public string $type = 'client';

    #[Validate('nullable|email')]
    public ?string $email;

    #[Validate('nullable|string|min:11')]
    public ?string $phone_number;

    #[Validate('required|string|min:11')]
    public string $cell_number;

    #[Validate('required|integer')]
    public int $cell_number_is_whatsapp = 1;

    public function mount(string $clientId)
    {
        $user         = Auth::user();
        $this->client = Client::where('store_id', $user->store_id)->findOrFail($clientId);

        $this->name                    = $this->client->name;
        $this->document                = $this->client->document;
        $this->document_type           = $this->client->document_type;
        $this->type                    = $this->client->type;
        $this->email                   = $this->client->email;
        $this->phone_number            = $this->client->phone_number;
        $this->cell_number             = $this->client->cell_number;
        $this->cell_number_is_whatsapp = $this->client->cell_number_is_whatsapp;
    }

    public function save()
    {
        $this->validate();
        Client::where('id', $this->client->id)->update($this->except('client'));
        redirect()->route('orders.create', ['client' => $this->client]);
    }

    public function render()
    {
        return view('livewire.clients.update-client');
    }
}
