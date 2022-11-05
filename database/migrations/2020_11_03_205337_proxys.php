<?php
declare(strict_types=1);

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
        Schema::create('proxys', function (Blueprint $table) {
            $table->id();
            $table->string('host')->unique();
            $table->integer('port')->index();
            $table->string('type')->default('unknown')->nullable()->index();
            $table->string('anonymity')->default('transparent')->index();
            $table->string('source')->nullable()->index();
            $table->string('speed')->nullable();
            $table->text('info')->nullable();
            $table->string('software')->nullable()->default('unknown');
            $table->timestamp('checked_at')->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
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
