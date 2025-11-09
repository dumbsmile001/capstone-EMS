<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('events', function (Blueprint $table){
            $table->id();
            $table->string('title', 50);
            $table->dateTime('event_date');
            $table->integer('duration');
            $table->enum('category', ['academic', 'sports', 'cultural']);
            $table->enum('scope', ['public', 'private']);
            $table->enum('status', ['published', 'drafted', 'cancelled']);
            $table->text('description');
            $table->boolean('require_payment');
            $table->integer('registered_participants');
            $table->integer('attended_participants');
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('events');
    }
};
