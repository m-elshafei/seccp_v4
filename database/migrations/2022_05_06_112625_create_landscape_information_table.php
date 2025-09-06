<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandscapeInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landscape_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('scanned')->default(false);
            $table->boolean('needs_welding_program')->nullable();
            $table->boolean('obstacles_exist_on_site')->nullable();
            $table->string('drilling_type')->nullable();
            $table->double('drilling_deep')->nullable();
            $table->integer('drilling_layer')->nullable();
            $table->string('landscape_date')->nullable();
            $table->integer('number_of_clips_dust')->nullable();
            $table->integer('number_of_clips_asphalt')->nullable();
            $table->integer('number_of_clips_sidewalk')->nullable();
            $table->integer('number_of_clips_total')->nullable();
            $table->double('length_dust')->nullable();
            $table->double('length_asphalt')->nullable();
            $table->double('length_sidewalk')->nullable();
            $table->double('length_total')->nullable();
            $table->double('length_dust_before')->nullable();
            $table->double('length_asphalt_before')->nullable();
            $table->double('length_sidewalk_before')->nullable();
            $table->double('length_total_before')->nullable();
            $table->double('cabel_length_hv')->nullable();
            $table->double('cabel_length_lv70')->nullable();
            $table->double('cabel_length_lv185')->nullable();
            $table->double('cabel_length_lv300')->nullable();
            $table->date("drilling_complete_date")->nullable();
            $table->enum('drilling_worker_type',['employee','contractor'])->default('employee');
            $table->foreignId('drilling_employee_id')->nullable();
            $table->foreignId('drilling_contractor_id')->nullable();
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
        Schema::dropIfExists('landscape_information');
    }
}
