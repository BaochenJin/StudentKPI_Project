<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalDegreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_degrees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('total_vals_id')->nullable();
            $table->String("degree")->nullable();
            $table->String("Midterm")->nullable();
            $table->String("Final")->nullable();
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
        Schema::dropIfExists('total_degree');
    }
}
