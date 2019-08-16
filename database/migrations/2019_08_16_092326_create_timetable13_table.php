<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimetable13Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable13', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('number');
            $table->string('department');


            $table->string('Monday12');
            $table->string('Monday34');
            $table->string('MondayNoon');
            $table->string('Monday56');
            $table->string('Monday78');

            $table->string('Tuesday12');
            $table->string('Tuesday34');
            $table->string('TuesdayNoon');
            $table->string('Tuesday56');
            $table->string('Tuesday78');

            $table->string('Wednesday12');
            $table->string('Wednesday34');
            $table->string('WednesdayNoon');
            $table->string('Wednesday56');
            $table->string('Wednesday78');

            $table->string('Thursday12');
            $table->string('Thursday34');
            $table->string('ThursdayNoon');
            $table->string('Thursday56');
            $table->string('Thursday78');

            $table->string('Friday12');
            $table->string('Friday34');
            $table->string('FridayNoon');
            $table->string('Friday56');
            $table->string('Friday78');

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
        Schema::dropIfExists('timetable13');
    }
}