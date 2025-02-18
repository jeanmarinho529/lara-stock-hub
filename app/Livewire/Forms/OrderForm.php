<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderForm extends Form
{
    #[Validate('required|string')]
    public string $payment_method = 'cash';

    #[Validate('required|string')]
    public string $installments = '1';

    #[Validate('required|string')]
    public string $amount = '';

    #[Validate('required|string')]
    public string $amount_received = '';

    public function setOrder(Order $order): void
    {
        $this->payment_method  = $order->payment_method;
        $this->installments    = $order->installments;
        $this->amount          = $order->amount;
        $this->amount_received = $order->amount_received;
    }
}
