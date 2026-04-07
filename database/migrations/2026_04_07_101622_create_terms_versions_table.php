<?php
// database/migrations/xxxx_xx_xx_create_terms_versions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terms_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version')->unique();
            $table->text('content');
            $table->text('summary')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('effective_date');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terms_versions');
    }
};