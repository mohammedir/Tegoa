<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactEmergencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('contact_emergency', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->bigInteger('scooter_numbe');
            $table->bigInteger('type')->comment('1(3-wheels)/ 2(4-wheels)');
            $table->bigInteger('phone_number');
            $table->bigInteger('status')->comment('1(active)/ 2(inactive)');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

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
        Schema::dropIfExists('contact_emergency');
    }
}
