<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAthletesAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->string("father_name", 255)->nullable();
            $table->date("birthdate")->nullable();
            $table->string("address", 255)->nullable();
            $table->string("id_number", 12)->nullable();
            $table->string("education", 255)->nullable();
            $table->string("job", 255)->nullable();
            $table->string("position", 255)->nullable();
            $table->string("cell", 12)->nullable();
            $table->string("cell_telegram", 12)->nullable();
            $table->string("emergency_phone", 12)->nullable();
            $table->string("referrer", 255)->nullable();
            $table->integer("ems_exp")->default(0);
            $table->string("sport_exp", 255)->nullable();
            $table->boolean("diet_weekly_call")->default(false);
            $table->boolean("before_session_call")->default(false);
            $table->boolean("goal_muscle")->default(false);
            $table->boolean("goal_ass_nice")->default(false);
            $table->boolean("goal_fat")->default(false);
            $table->boolean("goal_ass_small")->default(false);
            $table->boolean("goal_belly_small")->default(false);
            $table->boolean("goal_tit_nice")->default(false);
            $table->boolean("goal_belly_nice")->default(false);
            $table->boolean("goal_tit_small")->default(false);
            $table->boolean("goal_arm_muscle")->default(false);
            $table->boolean("goal_foot_nice")->default(false);
            $table->boolean("goal_arm_small")->default(false);
            $table->boolean("goal_foot_small")->default(false);
            $table->boolean("goal_back_nice")->default(false);
            $table->string("goal_other", 255)->nullable();
            $table->string("description", 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->dropColumn("father_name");
            $table->dropColumn("birthdate");
            $table->dropColumn("address");
            $table->dropColumn("id_number");
            $table->dropColumn("education");
            $table->dropColumn("job");
            $table->dropColumn("position");
            $table->dropColumn("cell");
            $table->dropColumn("cell_telegram");
            $table->dropColumn("emergency_phone");
            $table->dropColumn("referrer");
            $table->dropColumn("ems_exp");
            $table->dropColumn("sport_exp");
            $table->dropColumn("diet_weekly_call");
            $table->dropColumn("before_session_call");
            $table->dropColumn("goal_muscle");
            $table->dropColumn("goal_ass_nice");
            $table->dropColumn("goal_fat");
            $table->dropColumn("goal_ass_small");
            $table->dropColumn("goal_belly_small");
            $table->dropColumn("goal_tit_nice");
            $table->dropColumn("goal_belly_nice");
            $table->dropColumn("goal_tit_small");
            $table->dropColumn("goal_arm_muscle");
            $table->dropColumn("goal_foot_nice");
            $table->dropColumn("goal_arm_small");
            $table->dropColumn("goal_foot_small");
            $table->dropColumn("goal_back_nice");
            $table->dropColumn("goal_other");
            $table->dropColumn("description");
        });
    }
}
