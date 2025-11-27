<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop old columns that are no longer needed
            $table->dropColumn(['event_date', 'duration', 'scope', 'registered_participants', 'attended_participants']);
            
            // Add new columns
            $table->date('date')->after('title');
            $table->time('time')->after('date');
            $table->enum('type', ['online', 'face-to-face'])->after('time');
            $table->string('place_link', 500)->after('type');
            $table->string('banner')->nullable()->after('description');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('require_payment');
            $table->unsignedBigInteger('created_by')->after('status');
            
            // Modify existing columns if needed
            $table->string('title', 255)->change(); // Increase length from 50 to 255
            $table->enum('status', ['published', 'drafted', 'cancelled', 'archived'])->default('published')->change();
            
            // Add foreign key
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Reverse the changes - drop new columns and add back old ones
            $table->dropForeign(['created_by']);
            
            $table->dropColumn(['date', 'time', 'type', 'place_link', 'banner', 'payment_amount', 'created_by']);
            
            // Add back old columns
            $table->dateTime('event_date')->after('title');
            $table->integer('duration')->after('event_date');
            $table->enum('scope', ['public', 'private'])->after('category');
            $table->integer('registered_participants')->after('require_payment');
            $table->integer('attended_participants')->after('registered_participants');
            
            // Revert title length
            $table->string('title', 50)->change();
            $table->enum('status', ['published', 'drafted', 'cancelled'])->change();
        });
    }
};