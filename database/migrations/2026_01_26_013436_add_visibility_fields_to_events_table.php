<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('visibility_type')->default('all')->after('status');
            $table->json('visible_to_grade_level')->nullable()->after('visibility_type');
            $table->json('visible_to_shs_strand')->nullable()->after('visible_to_grade_level');
            $table->json('visible_to_year_level')->nullable()->after('visible_to_shs_strand');
            $table->json('visible_to_college_program')->nullable()->after('visible_to_year_level');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'visibility_type',
                'visible_to_grade_level',
                'visible_to_shs_strand',
                'visible_to_year_level',
                'visible_to_college_program'
            ]);
        });
    }
};