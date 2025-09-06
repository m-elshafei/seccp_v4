<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersPermitsExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders_permits_extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_orders_permit_id')->references('id')->on('work_orders_permits');
            $table->date('issue_date');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('sadad_number',150);
            $table->decimal('amount');
            $table->smallInteger('status');
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
        Schema::dropIfExists('work_orders_permits_extensions');
    }
}
