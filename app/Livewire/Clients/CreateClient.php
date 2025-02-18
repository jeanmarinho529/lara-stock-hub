<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateClient extends Component
{
    #[Validate('required|string|min:4')]
    public string $name;

    #[Validate('required|string|min:11')]
    public string $document;

    #[Validate('required|string|in:cpf,cnpj')]
    public string $document_type = 'cpf';

    #[Validate('required|string|in:client,supplier')]
    public string $type = 'client';

    #[Validate('email')]
    public ?string $email;

    #[Validate('string|min:11')]
    public ?string $phone_number;

    #[Validate('required|string|min:11')]
    public string $cell_number;

    #[Validate('required|integer')]
    public int $cell_number_is_whatsapp = 1;

    public function save()
    {
        $this->validate();

        $client = Client::firstOrCreate(
            [
                'store_id'      => Auth::user()->store_id,
                'document'      => $this->document,
                'document_type' => $this->document_type,
            ],
            $this->except('document', 'document_type')
        );

        redirect()->route('orders.create', ['client' => $client]);
    }

    public function render()
    {
        return view('livewire.clients.create-client');
    }
}
