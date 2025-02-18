<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClientForm extends Form
{
    #[Validate('required|string')]
    public string $store_id = '';

    #[Validate('required|string')]
    public string $name = '';

    #[Validate('required|string')]
    public string $document = '';

    #[Validate('required|string')]
    public string $document_type = '';

    #[Validate('required|string')]
    public string $type = '';

    #[Validate('nullable|string|email')]
    public ?string $email = null;

    #[Validate('nullable|string')]
    public ?string $phone_number = '';

    #[Validate('required|string')]
    public string $cell_number = '';

    #[Validate('required|string')]
    public string $cell_number_is_whatsapp = '';

    public function setClient(Client $client): void
    {
        $this->store_id                = $client->store_id;
        $this->name                    = $client->name;
        $this->document                = $client->document;
        $this->document_type           = $client->document_type;
        $this->type                    = $client->type;
        $this->email                   = $client->email;
        $this->phone_number            = $client->phone_number;
        $this->cell_number             = $client->cell_number;
        $this->cell_number_is_whatsapp = $client->cell_number_is_whatsapp;
    }
}
