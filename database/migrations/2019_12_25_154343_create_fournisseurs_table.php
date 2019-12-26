<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
          $table->increments('id');
          $table->string('Nom');
          $table->string('slug')->unique;
          $table->unsignedBigInteger('cp');
          $table->string('Ville');
          $table->string('Pays');
          $table->dateTime('CreeLe')->nullable()->default(null);
          $table->string('CreePar')->default('khatir');
          $table->dateTime('ModifieLe')->nullable()->default(null);
          $table->string('ModifiePar')->default('');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fournisseurs');
    }
}
