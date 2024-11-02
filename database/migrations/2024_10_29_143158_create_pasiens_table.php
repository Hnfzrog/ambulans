<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('tujuan');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('id_kru')->nullable();
            $table->unsignedBigInteger('id_koordinator')->nullable();
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('id_kru')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_koordinator')->references('id')->on('users')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
