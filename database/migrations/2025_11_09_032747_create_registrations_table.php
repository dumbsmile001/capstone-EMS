<?php

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->enum('status', ['attended', 'paid', 'cancelled']);
            $table->timestamp('registered_at');
        });
    }
    public function down(): void{
        Schema::dropIfExists('registrations');
    }
};
