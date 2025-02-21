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
        Schema::create('payment_method_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->enum(
                'type',
                ['receivable', 'payable']
            )->nullable();
            $table->enum(
                'payment_method',
                ['credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash']
            )->nullable();
            $table->tinyInteger('installments')->unsigned();
            $table->tinyInteger('transaction_effective_date')->unsigned();
            $table->double('tax')->unsigned();
            $table->boolean('auto_deduction');
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores');
            $table->unique(['store_id', 'type', 'payment_method', 'installments'], 'unq_payment_method_configs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_method_configs');
    }
};
