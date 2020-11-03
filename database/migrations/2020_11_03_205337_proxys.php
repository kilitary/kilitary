<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Proxys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxys', function(Blueprint $table) {
            $table->id();
            $table->string('host')->unique();
            $table->integer('port')->index();
            $table->string('type')->default('unknown')->nullable()->index();
            $table->string('anonymity')->default('transparent')->index();
            $table->string('source')->nullable()->index();
            $table->string('speed')->nullable();
            $table->text('info')->nullable();
            $table->timestamp('checked_at')->nullable()->index();
            $table->timestamp('added_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
