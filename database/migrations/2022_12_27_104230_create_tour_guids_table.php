<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourGuidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('tour_guids', function (Blueprint $table) {
            $table->id();
            $table->string('full name');
            $table->integer('gender')->comment('1(male)/ 2(female)');
            $table->text('spoken_languages');
            $table->string('email');
            $table->string('address');
            $table->string('phone_number');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('tour_guids');
    }
}
