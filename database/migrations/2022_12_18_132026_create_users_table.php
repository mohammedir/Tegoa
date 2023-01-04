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
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('email_verified_at')->nullable();
            $table->string('mobile_number')->nullable()->unique();
            $table->string('password');
            $table->string('api_token')->unique()->nullable()->default(null);
            $table->string('fcm_token')->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->text('address')->nullable();
            $table->integer('gender')->nullable()->comment('1(male)/ 2(female)');
            $table->integer('user_type')->comment('0(admin)/ 1(passenger) / 2(driver)');
            $table->string('roles_name')->nullable();
            $table->integer('roles_id')->nullable();
            $table->integer('user_status')->nullable()->default(1)->comment('1(active)/ 2(inactive)');
            $table->string('personalphoto')->nullable();
            $table->text('driverlicense')->nullable()->comment('to driver');
            $table->integer('vehicle_type')->nullable()->comment('to driver')->comment('1(public)/ 2(private)');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
