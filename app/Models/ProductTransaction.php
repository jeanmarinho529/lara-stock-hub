<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'total',
        'type',
        'payment_method',
        'local',
    ];
}
