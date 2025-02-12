<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("product_id");
            $table->integer("total");
            $table->enum('type', ['added', 'removed', 'transferred']);
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'pix','bank_slip','money']);
            $table->enum('local', ['store', 'stock']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
