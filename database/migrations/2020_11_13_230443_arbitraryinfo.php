<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Arbitraryinfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbitrary_info', function(Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('tags')->nullable();
            $table->string('key')->nullable();
            $table->string('ip')->nullable();
            $table->string('priority')->nullable();
            $table->json('json')->nullable();
            $table->text('text')->nullable();
            $table->softDeletes();
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
