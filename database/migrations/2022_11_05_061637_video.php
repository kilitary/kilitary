<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('category_old_name')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('tags')->nullable();
            $table->text('html')->nullable();
            $table->float('length')->nullable()->default(0.0);
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->integer('views')->nullable()->default(0);
            $table->string('code');
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
};
