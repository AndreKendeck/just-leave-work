<?php

use App\Reason;
use Illuminate\Database\Seeder;

class ReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = collect([
            [
                'name' => 'Sick Leave',
            ],
            [
                'name' => 'Family Responsibility Leave',
            ],
            [
                'name' => 'Maternity Leave',
            ],
            [
                'name' => 'Annual Leave',
            ],
            [
                'name' => 'Study Leave',
            ],
            [
                'name' => 'Religious Leave',
            ],
        ]);
        $reasons->each(function ($reason) {
            Reason::firstOrCreate($reason);
        });
    }
}
