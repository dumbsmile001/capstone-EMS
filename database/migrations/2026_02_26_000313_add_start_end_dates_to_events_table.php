<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Add new columns
            $table->date('start_date')->after('title');
            $table->time('start_time')->after('start_date');
            $table->date('end_date')->after('start_time');
            $table->time('end_time')->after('end_date');
            
            // Drop old columns
            $table->dropColumn(['date', 'time']);
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Restore old columns
            $table->date('date')->after('title');
            $table->time('time')->after('date');
            
            // Drop new columns
            $table->dropColumn(['start_date', 'start_time', 'end_date', 'end_time']);
        });
    }
};