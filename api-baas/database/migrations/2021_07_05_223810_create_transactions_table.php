<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_from');
            $table->uuid('wallet_to');
            $table->enum('status', ['processing', 'failed', 'success'])->default('processing');
            $table->unsignedBigInteger('total')->default(0.0);
            $table->string('gateway_code')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('wallet_from')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('wallet_to')
                ->references('id')
                ->on('wallets')
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
        Schema::dropIfExists('transactions');
    }
}
