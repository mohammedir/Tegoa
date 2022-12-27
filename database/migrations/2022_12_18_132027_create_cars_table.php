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
            $table->string('type');
            $table->bigInteger('car_number');
            $table->string('car_brand');
            $table->string('license_number');
            $table->bigInteger('insurance_number');
            $table->date('insurance_expiry_date');
            $table->text('carphotos')->nullable();
            $table->text('carlicense')->nullable();
            $table->text('carinsurance')->nullable();
            $table->text('passengersinsurance')->nullable();
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
