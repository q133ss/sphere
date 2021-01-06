<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->datetime('start');
            $table->datetime('end');
            $table->bigInteger('subject_id')->unsigned()->index()->nullable();
            $table->bigInteger('student_id')->unsigned()->index()->nullable();
            $table->bigInteger('teacher_id')->unsigned()->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
