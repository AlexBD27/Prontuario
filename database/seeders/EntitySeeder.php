<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Entity::create([
            'abbreviation' => 'PNP',
            'description' => 'Policía Nacional del Perú',
            'active' => true,
        ]);
    }
}
