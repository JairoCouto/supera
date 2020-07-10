<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
            $table->id('id_contrato')->autoIncrement();
            $table->double('cnpj', 14);
            $table->string('razao_social', 100);
            $table->string('nome_fantasia', 100);
            $table->string('email', 100);
            $table->string('logomarca', 100)->nullable();
            $table->integer('status')->nullable()->default(0)->comment('0-Ativo; 1-Inativo');
            $table->timestamps();

            $table->unique('cnpj');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato');
    }
}
