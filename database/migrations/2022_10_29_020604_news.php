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
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->default('#empty#');
            $table->timestamps();
            $table->string('source')->nullable()->default('#unkown#');
            $table->integer('views')->nullable()->default(0);
            $table->boolean('visible')->nullable()->default(true);
            $table->integer('added_by')->nullable()->default(-1);
            $table->text('content')->nullable();
            $table->text('url')->nullable();
            $table->text('category_name_old')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('length')->nullable();
            $table->softDeletes();
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
