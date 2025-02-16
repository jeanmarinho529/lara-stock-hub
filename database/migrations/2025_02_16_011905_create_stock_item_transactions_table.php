<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_item_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_item_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('quantity');
            $table->enum('type', ['added', 'removed', 'transferred', 'sold']);
            $table->enum('local', ['store', 'stock', 'others']);
            $table->double('amount')->unsigned();
            $table->double('amount_received')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('stock_item_id')->references('id')->on('stock_items');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_item_transactions');
    }
};
