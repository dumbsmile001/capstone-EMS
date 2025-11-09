<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Payment::class)->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->enum('status', ['verified', 'pending', 'unverified']);
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('receipts');
    }
};
