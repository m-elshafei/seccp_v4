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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('source_name')->nullable();
            $table->string('purchase_number')->nullable();
            $table->decimal('invoice_amount')->nullable();
            $table->string('material_reservation_number')->nullable();
            $table->string('electrical_station_number_2')->nullable();
            $table->string('reservation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('source_name');
            $table->dropColumn('purchase_number');
            $table->dropColumn('invoice_amount');
            $table->dropColumn('material_reservation_number');
            $table->dropColumn('electrical_station_number_2');
            $table->dropColumn('reservation');

        });
    }
};
