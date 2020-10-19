<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('entity')->nullable();
            $table->string('url')->nullable();
            $table->jsonb('values')->default('[]');
            $table->string('state')->default('published');
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
        Schema::dropIfExists('content_items');
    }
}
