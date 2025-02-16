<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    // ItemTransaction
    use SoftDeletes;

    // criar vendas
    // client_id
    // name (colocar algo como id da empresa e venda e nome do cleinte)
    // payment_method
    // installments
    // amount
    // amount_received
    // discount
    
    protected $fillable = [
        'order_id',
        'user_id',
        'item_id',
        'quantity',
        'type',
        'local',
        'amount',
        'amount_received',
    ];
}
