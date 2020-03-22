<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('team_id')->unsigned();

            $table->integer('number')->unsigned(); 
            $table->integer('user_id')->unsigned(); 
            $table->integer('reason_id')->unsigned(); 
            $table->longText('description'); 
            
            $table->timestamp('from'); 
            $table->timestamp('until'); 

            $table->timestamp('approved_at')->nullable(); 
            $table->timestamp('denied_at')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
