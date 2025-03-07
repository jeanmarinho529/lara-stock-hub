<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'brand_id',
        'store_id',
        'user_id',
        'name',
        'code',
        'type',
        'amount',
        'minimum_quantity',
        'unit_measurement',
        'description',
    ];

    public function getDisplayTypeAttribute()
    {
        $types = [
            'product' => 'Produto',
            'service' => 'Serviço',
        ];

        return $types[$this->type];
    }

    public function scopeSearchByCode($query, string $storeId, string $code)
    {
        return $query->select('id', 'brand_id', 'code', 'name', 'amount')
            ->with('brand:id,name')
            ->where('store_id', $storeId)
            ->where('code', 'like', "%$code%");
    }

    public function scopeSearchByName($query, string $storeId, ?string $name = null)
    {
        return $query->select('id', 'brand_id', 'code', 'name', 'amount')
            ->with('brand:id,name')
            ->where('store_id', $storeId)
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', "%$name%");
            });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productTransactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }
}
