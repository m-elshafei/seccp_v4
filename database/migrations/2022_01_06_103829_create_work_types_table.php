<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_types', function (Blueprint $table) {
            $table->id('id');
            $table->string('code');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->smallInteger('needs_drilling_operations')->default(0);
            $table->smallInteger('needs_electrical_work')->default(0);
            $table->smallInteger('needs_work_orders_permit')->default(0);
            $table->integer('default_department_id')->nullable();
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
        Schema::drop('work_types');
    }
}
