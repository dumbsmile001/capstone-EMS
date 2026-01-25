<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove program column
            $table->dropColumn('program');
            
            // Add new columns
            $table->enum('shs_strand', ['ABM', 'HUMSS', 'GAS', 'ICT'])->nullable();
            $table->enum('college_program', ['BSIT', 'BSBA'])->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore program column
            $table->string('program')->nullable();
            
            // Remove new columns
            $table->dropColumn(['shs_strand', 'college_program']);
        });
    }
};