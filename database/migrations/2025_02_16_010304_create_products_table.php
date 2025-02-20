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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('code');
            $table->enum('type', ['product', 'service'])->default('product');
            $table->double('amount')->unsigned();
            $table->integer('minimum_quantity')->unsigned()->default(1);
            $table->enum(
                'unit_measurement',
                ['unit', 'centimeter', 'meter', 'gram', 'kilogram', 'liter', 'milliliter']
            )->default('unit');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(['store_id', 'code'], 'unq_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
