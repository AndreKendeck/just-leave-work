<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReasonsAreInTableTest extends TestCase
{
    /**
    * @test
    */
    public function all_reasons_are_in_the_table_test()
    {
        $reasons = collect([
            'Sick Leave',
            'Family Responsibility Leave',
            'Maternity Leave',
            'Annual Leave',
            'Study Leave',
            'Leave for religious holidays',
            'Other',
        ]);
        $reasons->each(function ($reason) {
            $this->assertDatabaseHas('reasons', [
                'name' => $reason
            ]);
        });
    }
}
