<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_order_transactions_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('work_order_number')->nullable();
            $table->integer('old_status')->nullable();
            $table->integer('new_status')->nullable();
            $table->integer('old_department')->nullable();
            $table->integer('new_department')->nullable();
            $table->integer('type')->nullable();
            $table->string('description')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_transactions_history');
    }
};
