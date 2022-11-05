<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Abusers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abusers', static function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip')->nullable();
            $table->string('nick')->nullable();
            $table->string('ua')->nullable();
            $table->string('reason')->nullable();
            $table->integer('firewall_in')->nullable();
            $table->dateTime('deabusertime')->nullable();
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
    }
}
