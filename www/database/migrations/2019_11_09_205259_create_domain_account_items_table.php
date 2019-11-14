<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainAccountItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domain_account_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid')->nullable();
            $table->string('uuid')->nullable();
            $table->enum('type', ['godaddy', 'google'])->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->unsignedBigInteger('domain_account_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('domain_account_items', function (Blueprint $table) {
            $table->foreign('domain_account_id')
                ->references('id')
                ->on('domain_accounts')
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
        Schema::dropIfExists('domain_account_items');
    }
}
