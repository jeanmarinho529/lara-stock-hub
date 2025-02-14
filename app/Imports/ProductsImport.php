<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductTransaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;


class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = Auth::user();

        $product = Product::firstOrCreate([
            'store_id' => $user->store_id,
            'code' => $row['codigo_do_produto'],
        ], [
            'name' => $row['nome_do_produto'],
            'amount' => $row['valor_do_produto'],
            'description' => $row['descricao_do_produto'] ?? null,
            'user_id' => $user->id,
            'minimum_quantity' => $row['quantidade_minima_do_produto'] ?? 1,
        ]);

        ProductTransaction::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'total' => $row['total_da_movimentacao'],
            'type' => $row['tipo_da_movimentacao'] ?? 'added',
            'payment_method' => $row['metodo_de_pagamento'] ?? 'cash',
            'local' => $row['local'] ?? 'store',
            'amount' => $product->amount,
            'amount_received' => $row['valor_da_venda'] ?? $product->amount
        ]);

        return $product;
    }
}
