<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['pending_payment', 'active', 'used', 'cancelled'])->default('pending_payment');
            $table->timestamp('generated_at');
            $table->timestamp('used_at')->nullable();
            $table->text('qr_data')->nullable();
            $table->timestamps();

            $table->unique('ticket_number');
            $table->index('ticket_number');
            $table->index('status');
            $table->index('generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
