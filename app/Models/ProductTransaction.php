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
        'store_id',
        'user_id',
        'quantity',
        'type',
        'local',
        'amount',
    ];

    public function getDisplayTypeAttribute()
    {
        $types = [
            'added'       => 'Adicionado',
            'removed'     => 'Removido',
            'transferred' => 'Transferido',
            'sold'        => 'Vendido',
        ];

        return $types[$this->type];
    }

    public function getDisplayLocalAttribute()
    {
        $locals = [
            'store'  => 'Loja',
            'stock'  => 'Estoque',
            'others' => 'Outros',
        ];

        return $locals[$this->local];
    }

    public function getDisplayCreatedAtAttribute()
    {
        if (is_null($this->created_at)) {
            return null;
        }

        return $this->created_at->format('d/m/y H:i:s');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
