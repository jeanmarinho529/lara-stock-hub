<?php

namespace App\Livewire\Orders;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowOrder extends Component
{
    public Order $order;

    public Client $client;

    public $productTransactions;

    public $transactions;

    public function mount($orderId)
    {
        $user = Auth::user();

        $this->order = Order::select(
            'id',
            'client_id',
            'user_id',
            'payment_method',
            'installments',
            'gross_amount',
            'final_amount',
            'description',
            'created_at',
        )
            ->with(
                'user:id,name',
                'client:id,name,document,cell_number,store_id',
                'productTransactions:id,order_id,product_id,quantity,amount,local',
                'productTransactions.product:id,brand_id,name,code',
                'productTransactions.product.brand:id,name',
                'financialTransactions:id,order_id,payment_method,status,payment_estimate_at,payment_completed_at,gross_amount,paid_amount'
            )
            ->where('store_id', $user->store_id)
            ->findOrFail($orderId);

        $this->client              = $this->order->client;
        $this->productTransactions = $this->order->productTransactions;
        $this->transactions        = $this->order->financialTransactions ?? [];
    }

    public function render()
    {
        return view('livewire.orders.show-order');
    }
}
