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
        Schema::create('electricity_towers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedInteger('tower10')->default(0);
            $table->unsignedInteger('tower13')->default(0);
            $table->unsignedInteger('converter')->default(0);
            $table->unsignedInteger('shadad')->default(0);
            $table->unsignedInteger('grid_high_voltage')->default(0);
            $table->unsignedInteger('grid_low_voltage')->default(0);
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
        Schema::dropIfExists('electricity_towers');
    }
};
