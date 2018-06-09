<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->integer('reciter_id')->unsigned();
            $table->foreign('reciter_id')->references('id')->on('reciters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('album_id')->unsigned();
            $table->foreign('album_id')->references('id')->on('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('audio')->nullable();
            $table->string('video')->nullable();
            $table->integer('number');
            $table->smallInteger('status')->default(0);
            $table->dateTime('moderated_at')->nullable();
            $table->integer('moderated_by')->nullable()->unsigned();
            $table->integer('created_by')->nullable()->unsigned()->index();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['album_id', 'slug']);
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
        Schema::dropIfExists('tracks');
    }
}
