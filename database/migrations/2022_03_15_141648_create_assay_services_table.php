<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssayServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assay_services', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('assay_form_id')->references('id')->on('assay_forms');
            $table->foreignId('assay_form_id')->constrained();
            $table->foreignId('service_id')->constrained('work_order_services');
            // $table->foreignId('service_id')->references('id')->on('work_order_services');
            $table->double('quantity');
            $table->double('price');
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
        Schema::drop('assay_services');
    }
}
