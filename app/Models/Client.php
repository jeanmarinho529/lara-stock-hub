<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'name',
        'document',
        'document_type',
        'type',
        'email',
        'phone_number',
        'cell_number',
        'cell_number_is_whatsapp',
    ];
}
