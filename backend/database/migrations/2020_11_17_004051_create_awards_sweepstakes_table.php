<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsSweepstakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards_sweepstakes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('award_id');
            $table->unsignedBigInteger('sweepstakes_id');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('award_id')->references('id')->on('awards');
            $table->foreign('sweepstakes_id')->references('id')->on('sweepstakes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('awards_sweepstakes');
    }
}
