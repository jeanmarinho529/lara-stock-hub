<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodConfig extends Model
{
    protected $fillable = [
        'store_id',
        'type',
        'payment_method',
        'installments',
        'transaction_effective_date',
        'auto_deduction',
    ];
}
