<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuzzelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('puzzels')) {
        Schema::create('puzzels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image', 255);
            $table->string('stukjes', 255);
            $table->boolean('own');
            $table->boolean('gelegd');

            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puzzels');
    }
}
