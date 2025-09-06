<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid")->unique();
            $table->morphs("model");
            $table->string('path');
            $table->string('name')->comment("new file name");
            $table->string('filename')->comment("the original file name");
            $table->string('type');
            $table->string('extension');
            $table->unsignedInteger('size');
            $table->foreignId('attachment_type_id')->constrained('attachment_types');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->longText('metadata')->nullable();
            $table->string('driver_type')->nullable();
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
        Schema::dropIfExists('attachments');
    }
}
