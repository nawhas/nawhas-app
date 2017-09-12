<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->integer('reciter_id')->unsigned();
            $table->foreign('reciter_id')->references('id')->on('reciters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('year');
            $table->integer('hijri_year');
            $table->string('hijri_month');
            $table->string('image_path');
            $table->smallInteger('status')->default(0);
            $table->dateTime('moderated_at')->nullable();
            $table->integer('moderated_by')->nullable()->unsigned();
            $table->integer('created_by')->unsigned()->index();
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('albums');
    }
}
