<?php

namespace App\Models;

use Carbon\Carbon;
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
        'amount',
        'amount_paid',
        'status',
        'payment_estimate_at',
        'payment_completed_at',
        'status_changed_at',
        'description',
    ];

    public function getDisplayPaymentEstimateAtAttribute()
    {
        if (is_null($this->payment_estimate_at)) {
            return null;
        }

        return Carbon::parse($this->payment_estimate_at)->timezone('America/Sao_Paulo')->format('d/m/y');
    }

    public function getDisplayPaymentCompletedAtAttribute()
    {
        if (is_null($this->payment_completed_at)) {
            return null;
        }

        return Carbon::parse($this->payment_completed_at)->timezone('America/Sao_Paulo')->format('d/m/y');
    }

    public function getDisplayStatusChangedAtAttribute()
    {
        if (is_null($this->status_changed_at)) {
            return null;
        }

        return Carbon::parse($this->status_changed_at)->timezone('America/Sao_Paulo')->format('d/m/y H:i');
    }

    public function getDisplayPaymentMethodAttribute()
    {
        $methods = [
            'credit_card'   => 'Cartão de Crédito',
            'bank_transfer' => 'Transferência Bancária',
            'pix'           => 'PIX',
            'bank_slip'     => 'Boleto',
            'cash'          => 'Dinheiro',
        ];

        return $methods[$this->payment_method];
    }

    public function getDisplayStatusAttribute()
    {
        $methods = [
            'created'  => 'Criado',
            'done'     => 'Concluído',
            'partial'  => 'Parcial',
            'canceled' => 'Cancelado',
        ];

        return $methods[$this->status];
    }
}
