<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAthleteIdToNullableInSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->integer('athlete_id_1')->unsigned()->nullable()->change();
            $table->integer('athlete_id_2')->unsigned()->nullable()->change();
            $table->integer('athlete_id_3')->unsigned()->nullable()->change();
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
            $table->integer('athlete_id_1')->unsigned()->nullable(false)->change();
            $table->integer('athlete_id_2')->unsigned()->nullable(false)->change();
            $table->integer('athlete_id_3')->unsigned()->nullable(false)->change();
        });
    }
}
