<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TablesAreInDatabaseTest extends TestCase
{
    /**
    * @test
    */
    public function all_relevant_tables_are_migrated_to_the_database()
    {
        $tables = collect([
            'users',
            'password_resets',
            'failed_jobs',
            'notifications',
            'sessions',
            'leaves',
            'reasons',
            'comments',
            'roles',
            'permissions',
            'role_user',
            'permission_user',
            'permission_role',
            'organizations',
            'role_user',
            'permission_user',
        ]);
        $tables->each(function ($table) {
            $this->assertTrue(Schema::hasTable($table));
        });
    }
}
