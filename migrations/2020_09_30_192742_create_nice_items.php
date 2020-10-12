<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nice_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('entity')->nullable();
            $table->jsonb('values')->default('[]');
            $table->unsignedInteger('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nice_items');
    }
}
