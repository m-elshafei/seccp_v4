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
        Schema::create('work_order_notes', function (Blueprint $table) {
            $table->id();
            // $table->integer('work_order_id')->unsigned();
            $table->foreignId('work_order_id')->constrained();
            $table->string('work_order_number');
            $table->text('note');
            $table->integer('work_order_status');
            $table->integer('user_id');
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
        Schema::dropIfExists('work_order_notes');
    }
};
