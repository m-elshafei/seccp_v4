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
        Schema::create('land_layers', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('work_order_id')->references('id')->on('work_orders');
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('work_orders_permit_id')->constrained();
            // $table->foreignId('work_orders_permit_id')->references('id')->on('work_orders_permits');
            
            // $table->integer('layer_id');
            $table->foreignId('layer_id')->constrained('layers');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('lab_send_date')->nullable();
            $table->integer('layer_worker_type');
            // $table->integer('layer_employee_id')->nullable();
            $table->foreignId('layer_employee_id')->nullable()->constrained('employees');
            $table->foreignId('layer_contractor_id')->nullable()->constrained('contractors');
            // $table->integer('layer_contractor_id')->nullable();
            $table->integer('layer_status')->default(1);
            $table->foreignId('lab_id')->constrained();
            // $table->foreignId('lab_id')->references('id')->on('labs');
            
            $table->integer('lab_result_status')->default(1);
            $table->text('note')->nullable();
            $table->foreignId('branch_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('land_layers');
    }
};
