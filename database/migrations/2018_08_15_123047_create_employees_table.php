<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name');
            $table->string('image')->nullable();
            $table->date('employeementDay');
            $table->unsignedInteger('salary');

            $table->unsignedInteger('parent_id')->nullable();
//            $table->foreign('parent_id')->references('id')->on('employees');

            $table->unsignedInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
