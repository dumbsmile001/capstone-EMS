<?php

use App\Models\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('venues', function (Blueprint $table){
            $table->id();
            $table->foreignIdFor(Event::class)->constrained()->onDelete('cascade');
            $table->enum('type', ['online', 'face-to-face']);
            $table->string('place');
        });
    }
    public function down(): void{
        Schema::dropIfExists('venues');
    }
};
