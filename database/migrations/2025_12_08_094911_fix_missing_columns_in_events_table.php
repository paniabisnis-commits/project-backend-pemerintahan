<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {

            if (!Schema::hasColumn('events', 'title')) {
                $table->string('title')->after('id');
            }

            if (!Schema::hasColumn('events', 'description')) {
                $table->text('description')->after('title');
            }

            if (!Schema::hasColumn('events', 'event_date')) {
                // ✅ WAJIB nullable
                $table->date('event_date')->nullable()->after('description');
            }

            if (!Schema::hasColumn('events', 'image')) {
                $table->string('image')->nullable()->after('event_date');
            }

        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {

            if (Schema::hasColumn('events', 'image')) {
                $table->dropColumn('image');
            }

            if (Schema::hasColumn('events', 'event_date')) {
                $table->dropColumn('event_date');
            }

            if (Schema::hasColumn('events', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('events', 'title')) {
                $table->dropColumn('title');
            }

        });
    }
};
