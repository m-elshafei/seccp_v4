<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('english_name')->nullable();
            $table->string('short_name')->nullable();
            $table->integer('owner_id')->nullable();
            $table->string('company_membership_number')->nullable();
            $table->string('commercial_registration_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('company_reg_number')->nullable();
            $table->string('company_address')->nullable();
            $table->text('company_info')->nullable();
            $table->string('main_logo')->nullable();
            $table->string('second_logo')->nullable();
            $table->string('report_logo')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('stamp_path')->nullable();
            $table->string('admin_layout_name')->nullable();
            $table->json('settings')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
