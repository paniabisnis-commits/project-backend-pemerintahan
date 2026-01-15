<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable(); // TAMBAHKAN INI
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Optional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};