<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Calendar::factory(10)->create()->each(function ($calendar) {
            $calendar->appointments()->saveMany(\App\Models\Appointment::factory(10)->make());
        });
    }
}
