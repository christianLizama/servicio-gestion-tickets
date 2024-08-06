<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Concierto de Rock',
            'description' => 'Un increíble concierto de rock en vivo.',
            'start_date' => '2024-08-10 20:00:00',
            'end_date' => '2024-08-10 23:00:00',
            'price' => '100.00',
        ]);

        Event::create([
            'name' => 'Conferencia de Tecnología',
            'description' => 'Una conferencia sobre las últimas tendencias en tecnología.',
            'start_date' => '2024-09-15 09:00:00',
            'end_date' => '2024-09-15 17:00:00',
            'price' => '150.00',
        ]);
    }
}
