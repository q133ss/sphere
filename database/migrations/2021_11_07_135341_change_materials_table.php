<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class ChangeMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('material_cats', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            NestedSet::columns($table);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->bigInteger('cat_id')->unsigned()->nullable();
            $table->foreign('cat_id')->references('id')->on('material_cats')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('table', function (Blueprint $table) {
            NestedSet::dropColumns($table);
        });
    }
}
