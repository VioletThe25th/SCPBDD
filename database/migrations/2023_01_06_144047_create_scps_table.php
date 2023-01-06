<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scps', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->text('description');
            $table->timestamps();
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id')
                    ->references('id')
                    ->on('sites')
                    ->onUpdate('cascade')
                    ->onDelete('Cascade');
            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scps');
    }
}
