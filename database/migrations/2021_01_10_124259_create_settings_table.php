<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id');
            $table->boolean('automatic_leave_approval')->default(0);
            $table->integer('leave_added_per_cycle', false, true)->default(0);
            $table->integer('maximum_leave_days', false, true)->default(0);
            $table->integer('maximum_leave_balance', false, true)->default(0);
            $table->string('days_until_balance_added', false, true)->default(30);
            $table->boolean('can_approve_own_leave')->default(true);
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
        Schema::dropIfExists('settings');
    }
}
