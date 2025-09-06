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
        // Schema::table('work_orders', function (Blueprint $table) {
        //     $table->dropForeign(['project_id']);
        //     $table->dropForeign(['project_stage_id']);
        //     $table->dropForeign(['payment_clearance_id']);
        //     $table->dropForeign(['work_orders_stage_id']);
            
        //     $table->dropColumn(['project_id', 'project_stage_id','work_orders_stage_id', 'payment_clearance_id']);
        // });
        // Schema::table('work_orders', function (Blueprint $table) {
            
        //     $table->foreignId('project_id')->nullable()->constrained('work_orders_projects');
        //     // $table->foreignId('project_stage_id')->nullable()->constrained('work_orders_stages');
        //     $table->integer('project_stage_id')->nullable();
        //     $table->foreignId('work_orders_stage_id')->nullable()->constrained('work_orders_stages');
        //     $table->foreignId('payment_clearance_id')->nullable()->constrained('financial_dues');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('work_orders', function (Blueprint $table) {
        //     $table->dropForeign(['project_id']);
        //     $table->dropForeign(['project_stage_id']);
        //     $table->dropForeign(['payment_clearance_id']);
        //     $table->dropForeign(['work_orders_stage_id']);
            
        //     $table->dropColumn(['project_id', 'project_stage_id','work_orders_stage_id', 'payment_clearance_id']);
        // });
    }
};
