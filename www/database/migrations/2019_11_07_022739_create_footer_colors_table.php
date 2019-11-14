<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->foreign('sidenav_color_id')->references('id')->on('sidenav_colors')->onDelete('cascade');
            $table->foreign('navbar_color_id')->references('id')->on('navbar_colors')->onDelete('cascade');
            $table->foreign('footer_color_id')->references('id')->on('footer_colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('footer_colors');
    }
}
