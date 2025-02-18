<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'order_id',
        'user_id',
        'quantity',
        'type',
        'local',
        'amount',
        'amount_received',
    ];

    public function getDisplayLocalAttribute()
    {
        $types = [
            'store'  => 'Loja',
            'stock'  => 'Estoque',
            'others' => 'Outros',
        ];

        return $types[$this->local];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
