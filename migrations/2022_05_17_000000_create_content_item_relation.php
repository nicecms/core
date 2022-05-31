<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentItemRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_item_relations', function (Blueprint $table) {
            $table->id();
            $table->string('item_entity')->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->string('related_entity')->nullable();
            $table->unsignedInteger('related_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_item_relations');

    }
}
