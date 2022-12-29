<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsAndAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('news_and_announcements', function (Blueprint $table) {
            $table->id();
            $table->text('image');
            $table->text('title');
            $table->longText('article');
            $table->text('description');
            $table->integer('status')->default(1)->comment('1(active) / 0(inactive)');
            $table->bigInteger('type')->comment('1(news) / 2(announcements)');
            $table->softDeletes();
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
        Schema::dropIfExists('news_and_announcements');
    }
}
