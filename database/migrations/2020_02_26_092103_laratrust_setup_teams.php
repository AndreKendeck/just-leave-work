<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaratrustSetupTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing teams
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->string('display_name')->nullable();
            $table->integer('leader_id')->unsigned()->nullable(); 
            $table->string('description')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->timestamps();
        });

        Schema::table('role_user', function (Blueprint $table) {
            // Drop role foreign key and primary key
            $table->dropForeign(['role_id']);
            $table->dropPrimary(['user_id', 'role_id', 'user_type']);

            // Add team_id column
            $table->unsignedInteger('organization_id')->nullable();

            // Create foreign keys
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')
                ->onUpdate('cascade')->onDelete('cascade');

            // Create a unique key
            $table->unique(['user_id', 'role_id', 'user_type', 'organization_id']);
        });

        Schema::table('permission_user', function (Blueprint $table) {
           // Drop permission foreign key and primary key
            $table->dropForeign(['permission_id']);
            $table->dropPrimary(['permission_id', 'user_id', 'user_type']);

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            // Add team_id column
            $table->unsignedInteger('organization_id')->nullable();

            $table->foreign('organization_id')->references('id')->on('organizations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['user_id', 'permission_id', 'user_type', 'organization_id'] , 'Permisson_user_team' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::table('permission_user', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::dropIfExists('organizations');
    }
}
