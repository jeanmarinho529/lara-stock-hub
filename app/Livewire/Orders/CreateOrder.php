<?php

namespace App\Livewire\Orders;

use App\Models\Client;
use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateOrder extends Component
{
    // colocar unq para nao duplicar venda
    public Client $client;
    public string $searchProduct;
    public array $items;


    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function render()
    {
        return view('livewire.orders.create-order')->layout('layouts.app');
    }

    public function findItem()
    {
        $this->items[] = Item::where('code', $this->searchProduct)->first()->toArray();
        // return Item::where('code', $this->searchProduct)->first();
    }

    public function createOrder()
    {
        $user = Auth::user();

        // colcar em try catch

        $order = Order::create([
            'client_id' => $this->client->id,
            'user_id' => $user->id,
            'store_id' => $user->store_id,
            'payment_method' => 'cash',
            'installments' => 1,
            'amount' => 1,
            'amount_received' => 1,
        ]);

        // por enquanto sempre tirar do stock
        // dps colocar opcao de selcionar
        ItemTransaction::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'item_id' => $this->items[0]['id'],
            'quantity' => 1,
            'type' => 'sold',
            'local' => 'stock',
            // 'amount' => 1,
            // 'amount_received' => 1,
        ]);
    }
}
