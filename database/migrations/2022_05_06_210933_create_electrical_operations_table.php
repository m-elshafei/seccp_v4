<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectricalOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electrical_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer("status")->default(0);
            $table->date("electrical_complete_date")->nullable();
            $table->unsignedInteger('tablun')->nullable();
            $table->string('welding',150)->nullable();
            $table->string('welding_type')->nullable();
            $table->string('end',150)->nullable();
            $table->string('end_type')->nullable();
            $table->string('voltage')->nullable();
            $table->string('outlet_no')->nullable();
            $table->string('station_breaker')->nullable();
            $table->unsignedInteger('total_electrical_counters')->nullable();
            $table->enum('electrical_worker_type',['employee','contractor'])->default('employee');
            $table->foreignId('electrical_employee_id')->nullable();
            $table->foreignId('electrical_contractor_id')->nullable();
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
        Schema::dropIfExists('electrical_operations');
    }
}
