<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /**
         * ## RESTRICT: Rejeita a atualização ou exclusão de um registro da tabela pai, 
         * se houver registros na tabela filha.
         * ## CASCADE: Atualiza ou exclui os registros da tabela filha automaticamente, 
         * ao atualizar ou excluir um registro da tabela pai. 
         * ## SET NULL: Define como null o valor do campo na tabela filha, ao 
         * atualizar ou excluir o registro da tabela pai.
         * ## NO ACTION: Equivalente ao RESTRICT.
         */
        Schema::create('wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('code')->index();
            $table->enum('type', ['personal', 'business']);
            $table->bigInteger('balance')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
