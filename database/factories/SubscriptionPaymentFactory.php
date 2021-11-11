<?php

namespace Database\Factories;

use App\Subscription;
use App\SubscriptionPayment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubscriptionPaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubscriptionPayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => Str::random(), 
            'amount' => 199, 
            'currency' => 'ZAR', 
            'subcription_id' => Subscription::factory()->create()->id
        ];
    }
}
