<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultOfAthleteIdsToZeroInSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->integer('athlete_id_1')->unsigned()->default(0)->change();
            $table->integer('athlete_id_2')->unsigned()->default(0)->change();
            $table->integer('athlete_id_3')->unsigned()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->integer('athlete_id_1')->unsigned()->change();
            $table->integer('athlete_id_2')->unsigned()->change();
            $table->integer('athlete_id_3')->unsigned()->change();
        });
    }
}
