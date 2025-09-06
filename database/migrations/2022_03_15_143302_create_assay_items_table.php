<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssayItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assay_items', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('assay_form_id')->references('id')->on('assay_forms');
            $table->foreignId('assay_form_id')->constrained();
            $table->foreignId('item_id')->constrained();
            // $table->foreignId('item_id')->references('id')->on('items');
            $table->integer('spend');
            $table->integer('used');
            $table->integer('returned');
            $table->integer('returned_spend');
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
        Schema::drop('assay_items');
    }
}
