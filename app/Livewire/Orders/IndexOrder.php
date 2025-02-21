<?php

namespace App\Livewire\Orders;

use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class IndexOrder extends Component
{
    use WithPagination;

    public User $user;

    public ?int $clientDefaultId;

    public string $date = '';

    public string $payment_method = '';

    public string $sort = 'desc';

    protected $queryString = ['date', 'payment_method', 'sort'];

    public function mount()
    {
        $this->user = Auth::user();

        $this->clientDefaultId = Client::where('store_id', $this->user->store_id)
            ->where('email', 'client@default.com')
            ->first()->id ?? null;
    }

    public function render()
    {
        $order = Order::select(
            'id',
            'client_id',
            'user_id',
            'payment_method',
            'installments',
            'final_amount',
            'created_at',
        )
            ->with('user:id,name', 'client:id,name')
            ->when($this->date, function ($query) {
                return $query->where('created_at', '>', $this->date)
                    ->where('created_at', '<=', "$this->date 23:59:59");
            })
            ->when($this->payment_method, function ($query) {
                return $query->where('payment_method', $this->payment_method);
            })
            ->where('store_id', $this->user->store_id)
            ->orderBy('id', $this->sort)
            ->paginate(10);

        return view('livewire.orders.index-order', [
            'orders' => $order,
        ]);
    }
}
