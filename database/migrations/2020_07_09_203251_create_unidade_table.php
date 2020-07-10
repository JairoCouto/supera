<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->id('id_unidade')->autoIncrement();
            $table->unsignedBigInteger('id_contrato');
            $table->string('integracao', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('municipio', 100);
            $table->string('uf', 2);
            $table->string('logomarca', 100)->nullable();
            $table->integer('tipo')->nullable()->comment('0-Json; 1-Webview; 2-XML; 3-HL7');
            $table->integer('status')->nullable()->default(0)->comment('0-Ativo; 1-Inativo');
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
        Schema::dropIfExists('unidade');
    }
}
