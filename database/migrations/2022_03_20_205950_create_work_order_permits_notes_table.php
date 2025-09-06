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
        Schema::create('work_order_permits_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_orders_permits_id')->nullable()->constrained();
            $table->foreignId('work_order_id')->constrained();
            $table->string('permit_number');
            $table->text('note');
            $table->integer('work_orders_permits_status');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('work_order_permits_notes');
    }
};
