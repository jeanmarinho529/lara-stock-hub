<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockItemTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stock_item_id',
        'order_id',
        'user_id',
        'quantity',
        'type',
        'local',
        'amount',
        'amount_received',
    ];
}
