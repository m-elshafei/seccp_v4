<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersPermitWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_work_orders_permit', function (Blueprint $table) {
            $table->foreignId('work_order_id')->constrained('work_orders')->onDelete('cascade');;
            $table->foreignId('work_orders_permit_id')->constrained('work_orders_permits')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_order_work_orders_permit');
    }
}
