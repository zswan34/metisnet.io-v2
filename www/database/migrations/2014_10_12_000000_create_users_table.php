<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid')->unique()->nullable();
            $table->string('sid')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('recovery_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('ldap_user')->default(0);
            $table->boolean('disadvantaged')->default(0);
            $table->string('otp_secret')->nullable();
            $table->boolean('otp_exemption')->default(0);
            $table->longText('google2fa_secret')->nullable();
            $table->boolean('pkcs12')->default(0);
            $table->string('api_token')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->boolean('locked')->default(false);
            $table->integer('login_attempts')->default(0);
            $table->integer('login_max_attempts')->default(5);
            $table->string('token_2fa')->nullable();
            $table->datetime('token_2fa_expiry')->nullable();
            $table->boolean('change_password')->default(0);
            $table->boolean('terms')->default(false);
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('user_type_id')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->unsignedBigInteger('avatar_file_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
