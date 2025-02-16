<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'user_id',
        'store_id',
        'payment_method',
        'installments',
        'amount',
        'amount_received',
    ];
}
