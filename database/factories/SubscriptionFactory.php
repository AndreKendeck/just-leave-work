<?php

namespace Database\Factories;

use App\Subscription;
use App\SubscriptionPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => factory('App\Team')->create()->id,
            'starts_at' => now(),
            'ends_at' => now()->addDays(30),
            'subscription_payment_id' => SubscriptionPayment::factory()->create()->id,
        ];
    }
}
