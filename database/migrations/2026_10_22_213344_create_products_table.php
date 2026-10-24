<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150); // Ej: Cuaderno Argollado 5 Materias
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2); // Precio de venta
            $table->integer('stock')->default(0); // Control de inventario
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relación 1:N con categorías
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};