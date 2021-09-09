<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->enum('type', ['in', 'out', 'buy']);
            $table->enum('status', ['new', 'canceled', 'success'])->default('new');
            $table->string('comment')->nullable(); // may be keep here deleted users name or payment detal from PSP
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned()->index()->nullable(); // keep payments of deleted users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
