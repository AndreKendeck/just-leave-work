<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /** @test **/
    public function subscriptions_table_is_in_the_database()
    {
        $this->assertTrue(Schema::hasTable('subscriptions'));
        collect(['team_id', 'starts_at', 'ends_at', 'canceled_at', 'is_free_trial', 'subscription_payment_id'])
            ->each(fn(string $column) => $this->assertTrue(Schema::hasColumn('subscriptions', $column)));
    }

    /** @test **/
    public function subscription_payments_table_is_in_the_database()
    {
        $this->assertTrue(Schema::hasTable('subscription_payments'));
        collect(['reference', 'amount', 'currency', 'subscription_id'])
            ->each(fn(string $column) => $this->assertTrue(Schema::hasColumn('subscription_payments', $column)));
    }

    /** @test **/
    public function a_team_is_related_to_subscriptions()
    {
        $team = factory('App\Team')->create();
        $this->assertIsIterable($team->subscriptions);
        $this->assertIsBool($team->has_active_subscription);
    }
}
