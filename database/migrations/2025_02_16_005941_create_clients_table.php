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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('name');
            $table->string('document');
            $table->enum('document_type', ['cpf', 'cnpj']);
            $table->enum('type', ['client', 'supplier']);
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cell_number');
            $table->boolean('cell_number_is_whatsapp')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('stores');
            $table->unique(['store_id', 'type', 'document', 'document_type'], 'unq_clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
