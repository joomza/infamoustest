<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('infos', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name', 255);
            $table->string('phone', 15);
            $table->string('email', 255)->unique();
            $table->string('gender', 10);
            $table->date('dob');
            $table->text('biography');
            $table->string('photo', 255);
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
        //
        Schema::drop("infos");
    }
}
