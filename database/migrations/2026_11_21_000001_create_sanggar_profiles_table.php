<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Profil Sanggar & pengaturan situs (single record).
     */
    public function up(): void
    {
        Schema::create('sanggar_profiles', function (Blueprint $table) {
            $table->id();
            // Profil (konten) - dikelola Admin & Super Admin
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->year('founded_year')->nullable();
            $table->string('logo')->nullable();
            $table->string('script_image')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('leader_name')->nullable();
            $table->string('leader_title')->nullable();
            $table->string('leader_photo')->nullable();
            $table->text('leader_message')->nullable();
            // Pengaturan situs - khusus Super Admin
            $table->string('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('maps_embed_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanggar_profiles');
    }
};
