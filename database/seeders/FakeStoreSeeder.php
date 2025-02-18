<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FakeStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = Store::firstOrCreate([
            'document'      => '000.000.000-00',
            'document_type' => 'cpf',
        ], [
            'name'  => 'Test Store',
            'email' => 'store@test.com',
        ]);

        $user = User::firstOrCreate([
            'email' => 'user@test.com',
        ], [
            'name'     => 'Test User',
            'store_id' => $store->id,
            'password' => Hash::make('password'),
        ]);

        $brand = Brand::firstOrCreate([
            'store_id' => $store->id,
            'name'     => 'Test Brand',
        ]);

        $client = Client::firstOrCreate([
            'store_id'                => $store->id,
            'name'                    => 'Default Client',
            'document'                => '000.000.000-00',
            'document_type'           => 'cpf',
            'email'                   => 'client@default.com',
            'type'                    => 'client',
            'phone_number'            => '(84) 90000-000',
            'cell_number'             => '(84) 90000-000',
            'cell_number_is_whatsapp' => false,
        ]);

        Product::firstOrCreate([
            'brand_id'         => $brand->id,
            'store_id'         => $store->id,
            'user_id'          => $user->id,
            'name'             => 'Test Product',
            'code'             => '12345',
            'type'             => 'product',
            'amount'           => 15.5,
            'minimum_quantity' => 1,
            'unit_measurement' => 'unit',
            'description'      => null,
        ]);
    }
}
