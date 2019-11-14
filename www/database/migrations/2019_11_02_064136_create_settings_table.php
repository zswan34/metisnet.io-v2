<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('rtl_direction')->default(0);
            $table->boolean('material_style')->default(0);
            $table->enum('layout_style', ['static', 'offcanvas', 'fixed', 'fixed_offcanvas'])->default('fixed');
            $table->boolean('fixed_navbar')->default(0);
            $table->boolean('fixed_footer')->default(0);
            $table->boolean('reversed')->default(0);
            $table->unsignedBigInteger('navbar_color_id')->nullable()->default(3);
            $table->unsignedBigInteger('sidenav_color_id')->nullable()->default(3);
            $table->unsignedBigInteger('footer_color_id')->nullable()->default(3);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('color_theme_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('settings', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('color_theme_id')->references('id')->on('color_themes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
