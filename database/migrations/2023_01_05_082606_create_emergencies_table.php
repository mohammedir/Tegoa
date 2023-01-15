<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergencies', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->string('image');
            $table->bigInteger('scooter_number');
            $table->bigInteger('type')->comment('1(3-wheels)/ 2(4-wheels)');
            $table->bigInteger('phone_number');
            $table->bigInteger('status')->comment('1(active)/ 2(inactive)');
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
        Schema::dropIfExists('emergencies');
    }
};
