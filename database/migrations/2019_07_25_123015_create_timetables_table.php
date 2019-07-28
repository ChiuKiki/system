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


            $table->string('Monday1')->default(0);
            $table->string('Monday2')->default(0);
            $table->string('Monday3')->default(0);
            $table->string('Monday4')->default(0);
            $table->string('Monday5')->default(0);
            $table->string('Monday6')->default(0);
            $table->string('Monday7')->default(0);
            $table->string('Monday8')->default(0);
            $table->string('Monday9')->default(0);

            $table->string('Tuesday1')->default(0);
            $table->string('Tuesday2')->default(0);
            $table->string('Tuesday3')->default(0);
            $table->string('Tuesday4')->default(0);
            $table->string('Tuesday5')->default(0);
            $table->string('Tuesday6')->default(0);
            $table->string('Tuesday7')->default(0);
            $table->string('Tuesday8')->default(0);
            $table->string('Tuesday9')->default(0);

            $table->string('Wednesday1')->default(0);
            $table->string('Wednesday2')->default(0);
            $table->string('Wednesday3')->default(0);
            $table->string('Wednesday4')->default(0);
            $table->string('Wednesday5')->default(0);
            $table->string('Wednesday6')->default(0);
            $table->string('Wednesday7')->default(0);
            $table->string('Wednesday8')->default(0);
            $table->string('Wednesday9')->default(0);

            $table->string('Thursday1')->default(0);
            $table->string('Thursday2')->default(0);
            $table->string('Thursday3')->default(0);
            $table->string('Thursday4')->default(0);
            $table->string('Thursday5')->default(0);
            $table->string('Thursday6')->default(0);
            $table->string('Thursday7')->default(0);
            $table->string('Thursday8')->default(0);
            $table->string('Thursday9')->default(0);

            $table->string('Friday1')->default(0);
            $table->string('Friday2')->default(0);
            $table->string('Friday3')->default(0);
            $table->string('Friday4')->default(0);
            $table->string('Friday5')->default(0);
            $table->string('Friday6')->default(0);
            $table->string('Friday7')->default(0);
            $table->string('Friday8')->default(0);
            $table->string('Friday9')->default(0);

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
        Schema::dropIfExists('timetables');
    }
}
