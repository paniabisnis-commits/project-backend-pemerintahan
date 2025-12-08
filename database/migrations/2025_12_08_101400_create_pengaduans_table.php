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
    Schema::create('pengaduans', function (Blueprint $table) {
        $table->id();
        $table->string('nik', 16);
        $table->string('nama');
        $table->text('isi_pengaduan');
        $table->string('status')->default('Belum Ditanggapi');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
