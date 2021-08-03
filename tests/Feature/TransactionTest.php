<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransactionTest extends TestCase
{
    /** @test **/
    public function a_user_can_view_their_transactions()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user)
            ->get(route('transactions.index', ['userId' => $user->id]))
            ->assertOk()
            ->assertJsonStructure(['transactions', 'from', 'perPage', 'to', 'total', 'currentPage']);
    }
}
