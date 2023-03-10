<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type')->comment('1:public | 2:private');
            $table->string('car_number');
            $table->string('car_brand');
            $table->string('insurance_number');
            $table->date('insurance_expiry_date');
            $table->text('carphotos')->nullable();
            $table->text('carphotos2')->nullable();
            $table->text('carphotos3')->nullable();
            $table->text('carlicense')->nullable();
            $table->text('carinsurance')->nullable();
            $table->text('passengersinsurance')->nullable();
            $table->integer('is_email_verified')->nullable();
            $table->integer('status')->comment('0:in review | 1:accepted |2:declined')->default(0);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
