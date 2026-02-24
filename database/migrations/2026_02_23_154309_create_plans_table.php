<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_monthly', 10, 2);
            $table->decimal('price_yearly', 10, 2);
            $table->integer('max_contacts');
            $table->integer('max_messages');
            $table->integer('max_upload_mb');
            $table->integer('send_frequency_days');
            $table->json('allowed_frequencies');
            $table->boolean('allow_email')->default(true);
            $table->boolean('allow_sms')->default(false);
            $table->boolean('allow_whatsapp')->default(false);
            $table->boolean('allow_image')->default(true);
            $table->boolean('allow_video')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
