<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->string('mail', 155);
            $table->string('tel', 20);
            $table->timestamps();
            $table->unsignedBigInteger('site_id');
            $table->foreign('site_id')
                    ->references('id')
                    ->on('sites')
                    ->onUpdate('cascade')
                    ->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
