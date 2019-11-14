<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('extension');
            $table->timestamps();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('restriction_id')
                ->references('id')
                ->on('restrictions')
                ->onDelete('cascade');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('classification_id')
                ->references('id')
                ->on('classifications')
                ->onDelete('cascade');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->foreign('file_type_id')
                ->references('id')
                ->on('file_types')
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
        Schema::dropIfExists('file_types');
    }
}
