<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');
            $table->string('file_name')->nullable();
            $table->morphs('attachable');
            $table->timestamp('uploaded_at');
        });
    }
    public function down(): void{
        Schema::dropIfExists('attachments');
    }
};
