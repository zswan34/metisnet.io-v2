<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('extension')->nullable();
            $table->double('size')->nullable();
            $table->unsignedBigInteger('restriction_id')->nullable();
            $table->unsignedBigInteger('classification_id')->nullable();
            $table->unsignedBigInteger('file_type_id')->nullable();
            $table->unsignedBigInteger('upload_id')->nullable();
            $table->timestamps();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('upload_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('avatar_file_id')
                ->references('id')
                ->on('files')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
