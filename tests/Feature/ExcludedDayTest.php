<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExcludedDayTest extends TestCase
{
    const DAYS = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];
    /** @test **/
    public function a_user_can_store_any_day_as_an_admin()
    {
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);
        $day = array_rand(self::DAYS, 1);
        $this->actingAs($user)
            ->post(route('excludeddays.store'), ['day' => self::DAYS[$day]])
            ->assertSessionHasNoErrors()
            ->assertCreated()
            ->assertJsonStructure(['message', 'day']);
        $this->assertDatabaseHas('excluded_days', [
            'day' => self::DAYS[$day],
            'setting_id' => $user->team->settings->id,
        ]);
    }

    /** @test **/
    public function a_user_can_store_a_specific_day_as_admin()
    {
        $user = factory('App\User')->create();
        $user->attachRole('team-admin', $user->team);
        $day = $this->faker->date('d-m-Y');
        $this->actingAs($user)
            ->post(route('excludeddays.store'), ['day' => $day])
            ->assertSessionHasNoErrors()
            ->assertCreated()
            ->assertJsonStructure(['message', 'day']);
        $this->assertDatabaseHas('excluded_days', [
            'day' => $day,
            'setting_id' => $user->team->settings->id,
        ]);
    }
}
