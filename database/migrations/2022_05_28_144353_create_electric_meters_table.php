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
        Schema::create('electric_meters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('meter_no')->nullable();
            $table->string('subscription_no')->nullable();
            $table->double('reading')->nullable();
            $table->double('approved_capacity')->nullable();
            $table->double('previous_capacity')->nullable();
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
        Schema::dropIfExists('electric_meters');
    }
};
