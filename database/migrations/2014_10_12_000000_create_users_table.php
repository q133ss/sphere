<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->boolean('confirmed')->default(0);
            $table->boolean('confirm_request')->default(0);
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('photo')->nullable();
            $table->string('gmt')->nullable();
            $table->text('about')->nullable();
            $table->smallInteger('age')->unsigned()->default(0);
            $table->float('rate')->unsigned()->default(0);
            $table->float('lesson_price')->unsigned()->default(0);
            $table->string('phone')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->float('balance')->unsigned()->default(0);
            $table->bigInteger('role_id')->unsigned()->index()->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
