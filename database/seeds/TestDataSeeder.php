<?php

use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') === 'local') {
            factory('App\Team', 10)->create()->each(function ($team) {
                $users = factory('App\User', 12)->create(['team_id' => $team->id ])->each(function ($user) {
                    $user->assignRole('user');
                    factory('App\Leave', 3)->create([
                        'user_id' => $user->id,
                        'team_id' => $user->team_id
                    ]);
                });
                $users->random(5)->each(function ($user) {
                    $user->assignRole('reporter');
                });
            });
        }
    }
}
