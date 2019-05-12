<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); 
            $table->string('last_name'); //Apellido paterno
            $table->string('mother_last_name'); //Apellido materno
            $table->string('rfc');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE clients CHANGE id id INT(4) ZEROFILL NOT NULL auto_increment');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
