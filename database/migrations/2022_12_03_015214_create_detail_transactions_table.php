<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transactions', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('transactionId');
            $table->foreign('transactionId')->references('id')->on('transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('collectionId');
            $table->foreign('collectionId')->references('id')->on('collections')->onDelete('cascade')->onUpdate('cascade');
            $table->date('tanggalKembali')->nullable();
            $table->tinyInteger('status');
            $table->string('keterangan', 1000)->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transactions');
    }
};
