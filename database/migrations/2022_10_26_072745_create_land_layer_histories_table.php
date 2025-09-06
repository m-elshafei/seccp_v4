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
        Schema::create('land_layer_histories', function (Blueprint $table) {
            $table->id();
            $table->string('event_type')->default('created');
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('land_layer_id')->constrained();
            $table->foreignId('work_orders_permit_id')->constrained();
            // $table->foreignId('work_orders_permit_id')->references('id')->on('work_orders_permits');
            // $table->foreignId('user_id')->references('id')->on('users');
            // $table->foreignId('lab_id')->references('id')->on('labs');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lab_id')->constrained();
            $table->foreignId('layer_id')->constrained();
            $table->integer('layer_status');
            $table->integer('lab_result_status');
            $table->string('note')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained();
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
        Schema::dropIfExists('land_layer_histories');
    }
};
