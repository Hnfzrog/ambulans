<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayasTable extends Migration
{
    public function up()
    {
        Schema::create('biayas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('keterangan');
            $table->decimal('uang_masuk', 10, 2);
            $table->decimal('uang_keluar', 10, 2);
            $table->unsignedBigInteger('id_kru')->nullable();
            $table->unsignedBigInteger('id_koordinator')->nullable();
            $table->timestamps();

            $table->foreign('id_kru')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_koordinator')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('biayas');
    }
}
