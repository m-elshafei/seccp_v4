<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDuesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_dues', function (Blueprint $table) {
            $table->id();
            $table->string('due_no');
            $table->date('due_date');
            $table->smallInteger('status')->default(1);
            $table->foreignId('financial_due_type_id')->constrained();
            // $table->integer('financial_due_type_id');
            $table->foreignId('electricity_department_id')->nullable()->constrained('electricity_departments');
            // $table->integer('electricity_department_id')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->decimal('total_fines_amount')->nullable();
            $table->decimal('total_net_amount')->nullable();
            $table->decimal('total_final_amount')->nullable();
            $table->longText('notes')->nullable();
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
        Schema::drop('financial_dues');
    }
}
