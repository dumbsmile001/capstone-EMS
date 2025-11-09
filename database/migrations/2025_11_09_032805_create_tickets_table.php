<?php

use App\Models\Registration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Registration::class)->constrained()->onDelete('cascade');
            $table->integer('ticket_number');
            $table->string('file_path');
            $table->timestamp('issued_at');
        });
    }
    public function down(): void{
        Schema::dropIfExists('tickets');
    }
};
