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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('user_id');
            $table->enum(
                'payment_method',
                ['credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash']
            )->nullable();
            $table->tinyInteger('installments')->default(1);
            $table->double('amount')->unsigned();
            $table->double('amount_received')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
