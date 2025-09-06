<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_order_emergency_missions', function (Blueprint $table) {
            // $table->foreignId('emergency_mission_type_id')->nullable()->after('mission_complete_date');
            $table->foreignId('emergency_issues_type_id')->nullable()->constrained('emergency_issues_types');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_emergency_missions', function (Blueprint $table) {
            //
        });
    }
};
