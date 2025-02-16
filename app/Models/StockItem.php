<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class StockItem extends Model
{
    use SoftDeletes;
    use HasSlug;

    protected $fillable = [
        'brand_id',
        'store_id',
        'user_id',
        'name',
        'slug',
        'code',
        'amount',
        'minimum_quantity',
        'unit_measurement',
        'description',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
