<?php

use App\Models\Registration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Registration::class)->constrained()->onDelete('cascade');
            $table->decimal('payment_amount', 10, 2);
            $table->timestamp('verified_at');
        });
    }
    public function down(): void{
        Schema::dropIfExists('payments');
    }
};
