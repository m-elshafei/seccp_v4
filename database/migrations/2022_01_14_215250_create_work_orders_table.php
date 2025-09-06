<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('mission_number')->nullable();
            $table->date('received_date');
            $table->foreignId('work_type_id')->nullable()->constrained();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('district_id')->nullable()->constrained();
            $table->foreignId('parent_id')->nullable()->constrained('work_orders');
            
            $table->string('x_axis')->nullable();
            $table->string('y_axis')->nullable();
            $table->string('street_name')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile_number')->nullable();
            $table->string('electrical_station_number')->nullable();
            $table->integer('electrical_stations_type_id')->nullable()->unsigned();
            $table->integer('work_period')->default(30);
            $table->integer('status')->default(1);
            $table->date('finished_date')->nullable();
            $table->date('stop_date')->nullable();
            $table->text('stop_note')->nullable();
            $table->integer('drilling_status')->default(0);
            $table->integer('electrical_operations_status')->default(0);
            $table->integer('assay_forms_status')->default(0);
            $table->integer('gis_status')->default(0);
            
            /* for missions */
            $table->integer('is_emergency_mission')->default(0);
            $table->integer('mission_typeـid')->nullable();
            
            // $table->integer('mission_received_employee')->nullable();
            // $table->string('mission_opreation_number')->nullable();
            // $table->string('mission_meter_number')->nullable();
            // $table->integer('shift_number')->nullable();
            // $table->string('electricity_employee_name')->nullable();


            /*************** */
            $table->text('description')->nullable();
            $table->integer('consultant_id')->nullable();
            $table->foreignId('work_orders_stage_id')->nullable()->constrained();
            $table->foreignId('electricity_department_id')->nullable()->constrained('electricity_departments');
            $table->foreignId('current_department_id')->nullable()->constrained('departments');
            $table->foreignId('owner_department_id')->nullable()->constrained('departments');
            $table->foreignId('work_orders_type_id')->nullable()->constrained();
            $table->foreignId('project_id')->nullable()->constrained('work_orders_projects');
            // $table->foreignId('project_stage_id')->nullable()->constrained();
            $table->integer('project_stage_id')->nullable();
            // $table->integer('work_orders_stage_id')->nullable()->unsigned();
            $table->boolean('needs_drilling_operations')->default(false);
            $table->boolean('needs_electrical_work')->default(false);
            $table->boolean('needs_electrical_towers_work')->default(false);
            $table->boolean('needs_work_orders_permit')->default(false);
            $table->boolean('needs_program')->default(false);
            $table->boolean('has_asbuilt')->default(false);
            $table->string('asbuilt_number')->nullable();
            $table->integer('asbuilt_status')->default(0);
            $table->foreignId('achievement_certificate_id')->nullable()->constrained();
            $table->foreignId('payment_clearance_id')->nullable()->constrained('financial_dues');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');

        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('work_orders');
    }
}
