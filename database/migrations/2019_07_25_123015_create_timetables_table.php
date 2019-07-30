<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('number');


            $table->string('Monday1');
            $table->string('Monday2');
            $table->string('Monday3');
            $table->string('Monday4');
            $table->string('Monday5');
            $table->string('Monday6');
            $table->string('Monday7');
            $table->string('Monday8');
            $table->string('Monday9');

            $table->string('Tuesday1');
            $table->string('Tuesday2');
            $table->string('Tuesday3');
            $table->string('Tuesday4');
            $table->string('Tuesday5');
            $table->string('Tuesday6');
            $table->string('Tuesday7');
            $table->string('Tuesday8');
            $table->string('Tuesday9');

            $table->string('Wednesday1');
            $table->string('Wednesday2');
            $table->string('Wednesday3');
            $table->string('Wednesday4');
            $table->string('Wednesday5');
            $table->string('Wednesday6');
            $table->string('Wednesday7');
            $table->string('Wednesday8');
            $table->string('Wednesday9');

            $table->string('Thursday1');
            $table->string('Thursday2');
            $table->string('Thursday3');
            $table->string('Thursday4');
            $table->string('Thursday5');
            $table->string('Thursday6');
            $table->string('Thursday7');
            $table->string('Thursday8');
            $table->string('Thursday9');

            $table->string('Friday1');
            $table->string('Friday2');
            $table->string('Friday3');
            $table->string('Friday4');
            $table->string('Friday5');
            $table->string('Friday6');
            $table->string('Friday7');
            $table->string('Friday8');
            $table->string('Friday9');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
