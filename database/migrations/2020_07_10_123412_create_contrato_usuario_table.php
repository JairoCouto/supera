<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_usuario', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->id('id_contrato_usuario')->autoIncrement();
            $table->unsignedBigInteger('id_contrato');
            $table->double('cpf')->unique();
            $table->string('nome', 100);
            $table->timestamps();

            $table->foreign('id_contrato')->references('id_contrato')->on('contrato')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato_usuario');
    }
}
