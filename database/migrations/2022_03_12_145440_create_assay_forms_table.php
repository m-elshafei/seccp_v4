<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssayFormsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assay_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained();
            $table->foreignId('work_type_id')->constrained();
            $table->boolean('is_mission')->default(false);
            $table->text('notes')->nullable();
            $table->integer('status')->comment("1= new, 2= approved, 3= Moved")->default(1);
            $table->double('amount')->default(0);
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
        Schema::drop('assay_forms');
    }
}
