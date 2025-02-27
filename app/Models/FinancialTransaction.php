<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'create_by_user_id',
        'change_by_user_id',
        'store_id',
        'order_id',
        'type',
        'payment_method',
        'gross_amount',
        'paid_amount',
        'net_amount',
        'tax',
        'status',
        'payment_estimate_at',
        'payment_completed_at',
        'status_changed_at',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'payment_estimate_at'  => 'datetime:Y-m-d H:i:s',
            'payment_completed_at' => 'datetime:Y-m-d H:i:s',
            'status_changed_at'    => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function getDisplayPaymentEstimateAtAttribute()
    {
        if (is_null($this->payment_estimate_at)) {
            return null;
        }

        return $this->payment_estimate_at->format('d/m/y');
    }

    public function getDisplayPaymentCompletedAtAttribute()
    {
        if (is_null($this->payment_completed_at)) {
            return null;
        }

        return $this->payment_completed_at->format('d/m/y');
    }

    public function getDisplayStatusChangedAtAttribute()
    {
        if (is_null($this->status_changed_at)) {
            return null;
        }

        return $this->status_changed_at->format('d/m/y H:i');
    }

    public function getDisplayPaymentMethodAttribute()
    {
        $methods = [
            'credit_card'    => 'Cartão de Crédito',
            'bank_transfer'  => 'Transferência Bancária',
            'pix'            => 'PIX',
            'bank_slip'      => 'Boleto',
            'cash'           => 'Dinheiro',
            'future_payment' => 'Pagamento Futuro',
        ];

        return $methods[$this->payment_method];
    }

    public function getDisplayStatusAttribute()
    {
        $status = [
            'waiting'  => 'Aguardando',
            'paid'     => 'Pago',
            'partial'  => 'Parcial',
            'canceled' => 'Cancelado',
        ];

        return $status[$this->status];
    }
}
