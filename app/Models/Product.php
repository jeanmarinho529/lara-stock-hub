<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const TYPE_OPTIONS = ['Purchase', 'Sale', 'Refound'];

    const PAYMENT_METHOD_OPTIONS = ['credit_card', 'bank_transfer', 'pix','bank_slip'];

}
