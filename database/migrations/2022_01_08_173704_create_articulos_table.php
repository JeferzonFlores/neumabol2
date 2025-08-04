<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('cod_interno');
            $table->string('cod_barras');
            $table->string('descripcion');

            // Campos reintroducidos (estaban comentados/eliminados)
            $table->integer('costo_neto')->default(0); // Reintroducido con default(0)
            $table->integer('costo_imp')->default(0);  // Reintroducido con default(0)
            // Si tienes venta_neto y venta_imp también son importantes para el artículo
            // Si los quieres de vuelta:
            // $table->integer('venta_neto')->default(0);
            // $table->integer('venta_imp')->default(0);
            // Si quieres stock_critico también:
            // $table->integer('stock_critico')->default(0);

            // Campo 'stock' reintroducido
            $table->integer('stock')->default(0); // Reintroducido con default(0)

            $table->string('marca')->nullable(); 
            $table->string('modelo')->nullable(); 

            $table->boolean('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}