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
                'tag' => '<span class="bg-seaweed text-white text-xs whitespace-no-wrap px-2 rounded-lg mt-1"> SL </span>'
            ], 
            [
                'name' => 'Family Responsibility Leave' ,
                'tag' => '<span class="bg-purple-400 text-white text-xs whitespace-no-wrap px-2 rounded-lg mt-1"> FRL </span>',
            ],
            [
                'name' => 'Maternity Leave', 
                'tag' => '<span class="bg-pink-400 text-white text-xs whitespace-no-wrap px-2 rounded-lg mt-1"> ML </span>'
            ], 
            [
                'name' => 'Annual Leave', 
                'tag' => '<span class="bg-gray-600 text-white text-xs whitespace-no-wrap px-2 rounded-lg mt-1"> AL </span>'
            ],
            [
                'name' => 'Study Leave', 
                'tag' => '<span class="bg-gray-800 text-white text-xs whitespace-no-wrap px-2 rounded-lg mt-1"> SL </span>'
            ],
            [
                'name' => 'Religious Leave', 
                'tag' => '<span class="bg-green-400 text-white text-xs whitespace-no-wrap px-2 rounded-lg mt-1"> RL </span>'
            ],
        ]);
        $reasons->each( function($reason) {
            Reason::firstOrCreate($reason); 
        } );
    }
}
