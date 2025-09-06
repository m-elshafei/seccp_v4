<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id');
            $table->string('name',250);
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('job_id')->constrained();
            // $table->foreignId('branch_id')->references('id')->on('branches');
            // $table->foreignId('department_id')->references('id')->on('departments');
            // $table->foreignId('job_id')->references('id')->on('jobs');
            // $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('direct_manager_id')->nullable()->constrained('employees');
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
        Schema::drop('employees');
    }
}
