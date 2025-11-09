<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('q_r_data', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ticket::class)->constrained()->onDelete('cascade');
            $table->string('qr_data');
        });
    }
    public function down(): void{
        Schema::dropIfExists('q_r_data');
    }
};
