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
            $table->integer('organization_id')->unsigned();
            $table->integer('user_id')->unsigned(); 
            $table->integer('reason_id')->unsigned(); 
            $table->longText('description'); 
            // leave from to
            $table->timestamp('from'); 
            $table->timestamp('to'); 

            $table->timestamp('approved_at')->nullable(); 
            $table->integer('approved_by')->nullable(); 

            $table->timestamp('denied_at')->nullable(); 
            $table->integer('denied_by')->nullable(); 

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
