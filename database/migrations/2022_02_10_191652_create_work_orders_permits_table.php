<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersPermitsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders_permits', function (Blueprint $table) {
            $table->id();
            $table->string('permit_number')->nullable();
            $table->foreignId('work_orders_permit_type_id')->constrained();
            $table->foreignId('balady_id')->nullable()->constrained();
            $table->foreignId('district_id')->nullable()->constrained();
            $table->string('street')->nullable();
            $table->string('sadad_number', 150)->nullable();
            $table->decimal('issued_amount');
            $table->decimal('total_amount')->nullable();
            $table->decimal('total_extend_amount')->nullable();
            $table->decimal('total_fines_amount')->nullable();
            $table->integer('period');
            $table->date('issue_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('refuse_reason')->nullable();
            $table->smallInteger('status')->default(1);
            $table->boolean('is_mission')->default(false);

            $table->decimal('length_dust')->nullable();
            $table->decimal('length_asphalt')->nullable();
            $table->decimal('length_sidewalk')->nullable();
            $table->decimal('length_total')->nullable();
            $table->string('drilling_type')->nullable();
            $table->decimal('drilling_deep')->nullable();
            $table->integer('drilling_layer')->nullable();
            $table->decimal('drilling_width')->nullable();

            $table->string('clearance_sdad_number')->nullable();
            $table->date('clearance_sdad_date')->nullable();
            $table->decimal('clearance_sdad_amount')->nullable();

            $table->integer('completion_certificate_status')->default(0);
            $table->date('completion_certificate_date')->nullable();
            $table->integer('clearance_certificate_status')->default(0);
            $table->date('clearance_certificate_date')->nullable();
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
        Schema::drop('work_orders_permits');
    }
}
