<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateClient extends Component
{
    #[Validate('required|string|min:4')]
    public string $name;

    #[Validate('nullable|required_with:document_type|string|min:11')]
    public ?string $document;

    #[Validate('required_with:document|string|in:cpf,cnpj')]
    public string $document_type = '';

    #[Validate('required|string|in:client,supplier')]
    public string $type = 'client';

    #[Validate('nullable|required_if:type,supplier|email')]
    public ?string $email;

    #[Validate('nullable|string|min:11')]
    public ?string $phone_number;

    #[Validate('required|string|min:11')]
    public string $cell_number;

    #[Validate('required|integer')]
    public int $cell_number_is_whatsapp = 1;

    public function save()
    {
        $this->validate();

        try {
            $client = Client::create(
                array_merge(
                    ['store_id' => Auth::user()->store_id],
                    $this->all()
                ),
            );
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('waring', 'Celular do cliente já cadastrado!');

                return;
            }

            throw $e;
        }

        redirect()->route('orders.create', ['client' => $client]);
    }

    public function render()
    {
        return view('livewire.clients.create-client');
    }
}
