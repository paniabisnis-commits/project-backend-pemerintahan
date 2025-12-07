<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('beritas', function (Blueprint $table) {
            if (!Schema::hasColumn('beritas', 'title')) {
                $table->string('title');
            }

            if (!Schema::hasColumn('beritas', 'content')) {
                $table->text('content');
            }

            if (!Schema::hasColumn('beritas', 'image')) {
                $table->string('image')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['title', 'content', 'image']);
        });
    }
};
