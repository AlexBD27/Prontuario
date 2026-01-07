<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\AreaGroupType;
use App\Models\GroupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area::create([
            'abbreviation' => 'OCI',
            'description'=> 'Organo de Control Interno',
            'active' => true,
        ]);

        Area::create([
            'abbreviation' => 'AGI',
            'description'=> 'Area de Gestión Institucional',
            'active' => true,
        ]);

        Area::create([
            'abbreviation' => 'AGP',
            'description'=> 'Area de Gestión Pedagógica',
            'active' => true,
        ]);

        Area::create([
            'abbreviation' => 'ADR',
            'description'=> 'Area de Administración',
            'active' => true,
        ]);

        Area::create([
            'abbreviation' => 'DIR',
            'description'=> 'Dirección',
            'active' => true,
        ]);

        Area::create([
            'abbreviation' => 'AAJ',
            'description'=> 'Area de Asesoría Jurídica',
            'active' => true,
        ]);
    }
}
