<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('transportation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')->constrained('users')->cascadeOnDelete();
            $table->string('lat_from');
            $table->string('lng_from');
            $table->string('lat_to');
            $table->string('lng_to');
            $table->string('destination')->nullable();
            $table->string('departure_time');
            $table->bigInteger('number_of_passenger');
            $table->bigInteger('vehicle_type')->comment('1(public)/ 2(private)');
            $table->string('distance')->nullable();
            $table->string('expected_cost');
            $table->string('arrival_time');
            $table->foreignId('driver_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('1')->comment('1(waiting_driver)/2(accept_driver)/3(start_trip)/4(end_trip)/5(rejected)');
            $table->string('start_trip')->nullable();
            $table->string('end_trip')->nullable();
            $table->bigInteger('rating_car')->nullable();
            $table->bigInteger('rating_driver')->nullable();
            $table->bigInteger('rating_time')->nullable();
            $table->bigInteger('rating_passenger')->nullable();
            $table->longText('complaint')->nullable();
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
        Schema::dropIfExists('transportation_requests');
    }
}
