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
            'Sick Leave',
            'Family Responsibility Leave', 
            'Maternity Leave',
            'Annual Leave', 
            'Study Leave',
            'Leave for religious holidays',
            'Other', 
        ]);
        $reasons->each( function($reason) {
            Reason::firstOrCreate(['name' => $reason ]); 
        } );
    }
}
