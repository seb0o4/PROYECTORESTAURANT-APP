<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Crear tabla pedidos si no existe
        if (!Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('total', 10, 2);
                $table->string('estado')->default('pendiente');
                $table->json('items');
                $table->text('notas')->nullable();
                $table->timestamps();
            });
        }

        // Crear tabla facturas si no existe
        if (!Schema::hasTable('facturas')) {
            Schema::create('facturas', function (Blueprint $table) {
                $table->id();
                $table->string('numero')->unique();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('impuestos', 10, 2)->default(0);
                $table->decimal('total', 10, 2);
                $table->string('estado')->default('pendiente');
                $table->dateTime('fecha_emision');
                $table->dateTime('fecha_vencimiento');
                $table->text('concepto');
                $table->json('items');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('pedidos');
    }
};