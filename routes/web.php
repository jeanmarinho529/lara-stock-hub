<?php

use App\Livewire\Clients\CreateClient;
use App\Livewire\Clients\IndexClient;
use App\Livewire\Clients\UpdateClient;
use App\Livewire\Orders\CreateOrder;
use App\Livewire\Orders\IndexOrder;
use App\Livewire\Orders\ShowOrder;
use App\Livewire\Transactions\DashboardTransaction;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('vendas/', IndexOrder::class)->name('orders.index');
    Route::get('vendas/{orderId}', ShowOrder::class)->name('orders.show');

    Route::get('clientes/{client}/vendas', CreateOrder::class)
        ->name('orders.create');

    Route::get('financeiros/dashboard', DashboardTransaction::class)
        ->name('financial.dashboard');

    Route::get('clientes', IndexClient::class)
        ->name('clients.index');

    Route::get('clientes/criar', CreateClient::class)
        ->name('clients.create');

    Route::get('clientes/{clientId}/editar', UpdateClient::class)
        ->name('clients.update');
});

require __DIR__ . '/auth.php';
