<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimetable16Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable16', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('number');
            $table->string('department');


            $table->string('Monday12');
            $table->string('Monday34');
            $table->string('Monday56');
            $table->string('Monday78');
            $table->string('Monday911');

            $table->string('Tuesday12');
            $table->string('Tuesday34');
            $table->string('Tuesday56');
            $table->string('Tuesday78');
            $table->string('Tuesday911');

            $table->string('Wednesday12');
            $table->string('Wednesday34');
            $table->string('Wednesday56');
            $table->string('Wednesday78');
            $table->string('Wednesday911');

            $table->string('Thursday12');
            $table->string('Thursday34');
            $table->string('Thursday56');
            $table->string('Thursday78');
            $table->string('Thursday911');

            $table->string('Friday12');
            $table->string('Friday34');
            $table->string('Friday56');
            $table->string('Friday78');
            $table->string('Friday911');

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
        Schema::dropIfExists('timetable16');
    }
}
