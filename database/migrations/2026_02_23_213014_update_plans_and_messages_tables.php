<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🔹 Actualizar tabla plans
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'max_campaigns')) {
                $table->renameColumn('max_campaigns', 'max_messages');
            }
        });

        // 🔹 Actualizar tabla messages
        Schema::table('messages', function (Blueprint $table) {

            if (!Schema::hasColumn('messages', 'status')) {
                $table->string('status')
                      ->default('draft')
                      ->after('channel');
            }

            if (!Schema::hasColumn('messages', 'media_path')) {
                $table->string('media_path')
                      ->nullable()
                      ->after('content');
            }

            if (!Schema::hasColumn('messages', 'scheduled_at')) {
                $table->timestamp('scheduled_at')
                      ->nullable()
                      ->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'max_messages')) {
                $table->renameColumn('max_messages', 'max_campaigns');
            }
        });

        Schema::table('messages', function (Blueprint $table) {

            if (Schema::hasColumn('messages', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('messages', 'media_path')) {
                $table->dropColumn('media_path');
            }

            if (Schema::hasColumn('messages', 'scheduled_at')) {
                $table->dropColumn('scheduled_at');
            }
        });
    }
};