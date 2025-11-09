<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(): void{
        Schema::create('announcements', function (Blueprint $table){
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('category', ['general', 'event', 'reminder']);
            $table->text('description');
            $table->boolean('visibility');
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('announcements');
    }
};
