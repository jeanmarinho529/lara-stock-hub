<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'store_id',
        'user_id',
        'payment_method',
        'installments',
        'amount',
        'amount_received',
        'description',
    ];

    public function getDisplayCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/y H:i');
    }

    public function getDisplayPaymentMethodAttribute()
    {
        $paymentMethods = [
            'credit_card'   => 'Cartão de Crédito',
            'bank_transfer' => 'Transferência Bancária',
            'pix'           => 'PIX',
            'bank_slip'     => 'Boleto',
            'cash'          => 'Dinheiro',
        ];

        return $paymentMethods[$this->payment_method];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function productTransactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
