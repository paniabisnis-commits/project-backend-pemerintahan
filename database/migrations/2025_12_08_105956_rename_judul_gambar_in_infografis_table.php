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
    Schema::table('infografis', function (Blueprint $table) {
        $table->renameColumn('judul', 'title');
        $table->renameColumn('gambar', 'image');
    });
}

public function down()
{
    Schema::table('infografis', function (Blueprint $table) {
        $table->renameColumn('title', 'judul');
        $table->renameColumn('image', 'gambar');
    });
}
};
