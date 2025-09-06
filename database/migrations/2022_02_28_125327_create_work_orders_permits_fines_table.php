<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersPermitsFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders_permits_fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_orders_permit_id')->constrained('work_orders_permits');
            $table->date('issue_date');
            $table->string('sadad_number',150);
            $table->decimal('amount');
            $table->longText('fine_reason')->nullable();
            $table->longText('notes')->nullable();
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('work_orders_permits_fines');
    }
}
