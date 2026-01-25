<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('program', ['ABM', 'HUMSS', 'GAS', 'ICT', 'BSIT', 'BSBA'])
                  ->nullable()
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('program')->nullable()->change();
        });
    }
};