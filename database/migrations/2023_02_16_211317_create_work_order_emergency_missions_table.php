<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_emergency_missions', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('work_order_id')->references('id')->on('work_orders');
            $table->foreignId('work_order_id')->constrained();
            // $table->integer('mission_typeـid')->nullable();
            // $table->integer('shift_number')->nullable();
            $table->foreignId('mission_received_employee')->nullable()->constrained('employees');
            // $table->integer('mission_received_employee')->nullable();
            $table->string('mission_operation_number')->nullable();
            $table->string('mission_meter_number')->nullable();
            $table->string('electricity_employee_name')->nullable();
            $table->enum('mission_executed_worker_type',['employee','contractor'])->default('employee');
            $table->foreignId('mission_executed_employee_id')->nullable()->constrained(
                table: 'employees', 
                indexName: 'mission_ex_emp_id_foreign'
            );
            
            $table->foreignId('mission_executed_contractor_id')->nullable()->constrained(
                table: 'contractors', 
                indexName: 'mission_ex_contr_foreign'
            );

            // $table->integer('mission_executed_employee_id')->nullable();
            // $table->integer('mission_executed_contractor_id')->nullable();
            $table->date("mission_complete_date")->nullable();
            
            $table->foreignId('branch_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_order_emergency_missions');
    }
};
