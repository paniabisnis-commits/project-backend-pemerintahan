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
    // CEK DULU apakah tabel sudah ada
    if (!Schema::hasTable('layanans')) {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('nama_layanan');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }
}

public function down()
{
    Schema::dropIfExists('layanans');
}
};
