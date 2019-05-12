<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cliente')->unsigned();
            $table->foreign('id_cliente')->references('id')->on('clients');

            $table->decimal('enganche', 15, 2);
            $table->decimal('bonificacion_enganche', 15, 2);
            $table->decimal('total', 15, 2);

            $table->decimal('ahorro', 15, 2);
            $table->decimal('pago_mensual', 15, 2);
            $table->integer('plazo');
            $table->string('estado', 20);
            $table->timestamps();
        });

         DB::statement('ALTER TABLE ventas CHANGE id id INT(4) ZEROFILL NOT NULL auto_increment');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
