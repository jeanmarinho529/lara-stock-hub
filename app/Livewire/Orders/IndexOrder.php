<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexOrder extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();

        $order = Order::select(
            'id',
            'client_id',
            'user_id',
            'payment_method',
            'installments',
            'amount_received',
            'created_at',
        )
            ->with('user:id,name', 'client:id,name')
            ->where('store_id', $user->store_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.orders.index-order', [
            'orders' => $order,
        ]);
    }
}
