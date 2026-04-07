<?php
// database/migrations/xxxx_xx_xx_create_term_agreements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('term_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('terms_version_id')->constrained()->onDelete('cascade');
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'terms_version_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('term_agreements');
    }
};