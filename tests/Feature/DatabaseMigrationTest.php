<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseMigrationTest extends TestCase
{
    /** @test **/
    public function migration_2021_08_31_adds_country_id_to_settings_table()
    {
        $this->assertTrue(Schema::hasColumn('settings', 'country_id'));
    }

    /** @test **/
    public function migration_2021_10_16_adds_use_public_holiday_column_to_setttings_table()
    {
        $this->assertTrue(Schema::hasColumn('settings', 'use_public_holidays'));
    }

    /** @test **/
    public function migration_2021_10_01_adds_adjustment_to_leaves_table()
    {
        $this->assertTrue(Schema::hasColumn('leaves', 'adjustment'));
    }
}
