<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSweepstakeResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sweepstake_result', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('award_sweepstake_id');
            $table->unsignedBigInteger('participant_id');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('award_sweepstake_id')->references('id')->on('awards_sweepstakes');
            $table->foreign('award_sweepstake_id')->references('id')->on('participants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sweepstake_result');
    }
}
