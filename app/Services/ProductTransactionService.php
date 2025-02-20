<?php

namespace App\Services;

use App\Models\ProductTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductTransactionService
{
    public function quantity(string $type, int $quantity): int
    {
        if (in_array($type, ['removed', 'transferred', 'sold'])) {
            return abs($quantity) * -1;
        }

        return abs($quantity);
    }

    public function createProductTransaction(
        string $productId,
        int $quantity,
        string $type,
        string $local,
        float $amount = 0,
        ?string $orderId = null,
        ?string $localTransfer = null,
        ?User $user = null
    ) {
        $user = $user ?? Auth::user();

        try {
            DB::beginTransaction();

            ProductTransaction::create([
                'product_id' => $productId,
                'store_id'   => $user->store_id,
                'order_id'   => $orderId,
                'user_id'    => $user->id,
                'quantity'   => $this->quantity($type, $quantity),
                'type'       => $type,
                'local'      => $local,
                'amount'     => $amount,
            ]);

            if ($type == 'transferred') {
                $this->createProductTransaction(
                    $productId,
                    $quantity,
                    'added',
                    $localTransfer,
                    0,
                    $orderId,
                    $user
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
