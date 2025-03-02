<?php

namespace App\Services;

class PaymentMethodsService
{
    public static function methods(): array
    {
        return [
            'pix'            => 'PIX',
            'credit_card'    => 'Cartão de Crédito',
            'cash'           => 'Dinheiro',
            'debit'          => 'Debito',
            'bank_transfer'  => 'Transferência Bancária',
            'bank_slip'      => 'Boleto',
            'future_payment' => 'Pagamento Futuro',
        ];
    }

    public static function findMethod(string $name): string
    {
        return self::methods()[$name];
    }
}
