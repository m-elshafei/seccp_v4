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
        Schema::table('work_orders_permits', function (Blueprint $table) {
            $table->integer('total_extend_period')->nullable()->after('period');
            $table->integer('total_period')->nullable()->after('total_extend_period');
            $table->date('end_date_final')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
