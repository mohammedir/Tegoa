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
            $table->string('mobile_number')->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->integer('user_type');
            $table->integer('user_status')->nullable()->default(1);
            $table->string('personal_photo')->nullable();
            $table->text('driver_license')->nullable()->comment('to driver');
            $table->text('vehicle_type')->nullable()->comment('to driver');
            $table->text('roles_name')->nullable();
            $table->integer('roles_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

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
