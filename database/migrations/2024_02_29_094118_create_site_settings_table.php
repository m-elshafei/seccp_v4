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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id('id');
            $table->string('site_name_en')->nullable();
            $table->string('site_name_ar')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('big_photo')->nullable();
            $table->string('company_name')->nullable();
            $table->text('site_alias')->nullable();
            $table->text('site_main_color')->nullable();
            $table->text('site_font_name')->nullable();
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
        Schema::drop('site_settings');
    }
};
