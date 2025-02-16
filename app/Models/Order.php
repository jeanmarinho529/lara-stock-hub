<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'store_id',
        'user_id',
        'payment_method',
        'installments',
        'amount',
        'amount_received',
    ];
}
