<?php

namespace Database\Seeders;

use App\Models\GroupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GroupType::create([
            'abbreviation' => 'SEC',
            'description'=> 'Secretaría',
            'active' => true,
        ]);

        GroupType::create([
            'abbreviation' => 'JEF',
            'description'=> 'Jefatura',
            'active' => true,
        ]);

        GroupType::create([
            'abbreviation' => 'EQU',
            'description'=> 'Equipos',
            'active' => true,
        ]);

        GroupType::create([
            'abbreviation' => 'COM',
            'description'=> 'Comisiones',
            'active' => true,
        ]);

        GroupType::create([
            'abbreviation' => 'ESP',
            'description'=> 'Especialistas',
            'active' => true,
        ]);
    }
}
