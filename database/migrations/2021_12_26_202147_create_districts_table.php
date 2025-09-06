<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id('id');
            $table->string('name',150);
            $table->foreignId('city_id')->references('id')->on('cities');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users');//->constrained('users');
            $table->foreignId('updated_by')->constrained('users');//->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('districts');
    }
}
