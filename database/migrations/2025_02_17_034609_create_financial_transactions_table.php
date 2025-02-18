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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('create_by_user_id');
            $table->unsignedBigInteger('change_by_user_id')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->enum(
                'type',
                ['receivable', 'payable']
            )->nullable();
            $table->enum(
                'payment_method',
                ['credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash']
            )->nullable();
            $table->double('amount');
            $table->double('amount_paid')->default(0);
            $table->enum('status', ['created', 'done', 'partial', 'canceled']);
            $table->timestamp('payment_estimate_at');
            $table->timestamp('payment_completed_at')->nullable();
            $table->timestamp('status_changed_at');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('create_by_user_id')->references('id')->on('users');
            $table->foreign('change_by_user_id')->references('id')->on('users');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
