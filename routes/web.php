<?php

use App\Http\Middleware\UserIsAdmin;
use App\Livewire\Brands\CreateBrand;
use App\Livewire\Brands\IndexBrand;
use App\Livewire\Brands\UpdateBrand;
use App\Livewire\Clients\CreateClient;
use App\Livewire\Clients\IndexClient;
use App\Livewire\Clients\UpdateClient;
use App\Livewire\Orders\CreateOrder;
use App\Livewire\Orders\IndexOrder;
use App\Livewire\Orders\ShowOrder;
use App\Livewire\Products\CreateProduct;
use App\Livewire\Products\CreateProductTransaction;
use App\Livewire\Products\IndexProduct;
use App\Livewire\Products\IndexProductTransaction;
use App\Livewire\Products\UpdateProduct;
use App\Livewire\Transactions\DashboardTransaction;
use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified']);

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/', IndexOrder::class)->name('dashboard');

    Route::get('vendas/', IndexOrder::class)->name('orders.index');
    Route::get('vendas/{orderId}', ShowOrder::class)->name('orders.show');

    Route::get('clientes/{client}/vendas', CreateOrder::class)
        ->name('orders.create');

    Route::get('financeiros/dashboard', DashboardTransaction::class)
        ->name('financial.dashboard')->middleware(UserIsAdmin::class);

    Route::get('produtos', IndexProduct::class)
        ->name('products.index');
    Route::get('produtos/criar', CreateProduct::class)
        ->name('products.create');
    Route::get('produtos/{productId}/editar', UpdateProduct::class)
        ->name('products.update');

    Route::get('produtos/{productId?}/movimentacoes', IndexProductTransaction::class)
        ->name('products.transactions');
    Route::get('produtos/movimentacoes', IndexProductTransaction::class)
        ->name('products.transactions.index');
    Route::get('produtos/movimentacoes/criar', CreateProductTransaction::class)
        ->name('products.transactions.create');

    Route::get('marcas', IndexBrand::class)
        ->name('brands.index');
    Route::get('marcas/criar', CreateBrand::class)
        ->name('brands.create');
    Route::get('marcas/{id}/editar', UpdateBrand::class)
        ->name('brands.edit');

    Route::get('clientes', IndexClient::class)
        ->name('clients.index');
    Route::get('clientes/criar', CreateClient::class)
        ->name('clients.create');
    Route::get('clientes/{clientId}/editar', UpdateClient::class)
        ->name('clients.update');
});

require __DIR__ . '/auth.php';
