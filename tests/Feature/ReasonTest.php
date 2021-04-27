<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReasonTest extends TestCase
{
    /** @test **/
    public function it_returns_all_the_leave_reasons()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('reasons.index'))
            ->assertOk();
    }
}
