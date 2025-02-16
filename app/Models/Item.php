<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    // Item
    use SoftDeletes;
    use HasSlug;

    protected $fillable = [
        'user_id',
        'store_id',
        'name',
        'slug',
        'description',
        'amount',
        'code',
        'minimum_quantity',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
