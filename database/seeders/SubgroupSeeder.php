<?php

namespace Database\Seeders;

use App\Models\Subgroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubgroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*Subgroup::create([
            'group_id' => 2,
            'abbreviation' => 'SUB1',
            'description'=> 'Subgrupo de Equipo 1 de AGI',
            'active' => true,
        ]);

        Subgroup::create([
            'group_id' => 3,
            'abbreviation' => 'SUB2',
            'description'=> 'Subgrupo de Equipo 2 de AGI',
            'active' => true,
        ]);*/

        Subgroup::create([
            'group_id' => 9,
            'abbreviation' => 'SUB1_OCI',
            'description'=> 'Subgrupo de Equipo 1 de OCI',
            'active' => true,
        ]);

        Subgroup::create([
            'group_id' => 10,
            'abbreviation' => 'SUB2_OCI',
            'description'=> 'Subgrupo de Equipo 2 de OCI',
            'active' => true,
        ]);

        Subgroup::create([
            'group_id' => 11,
            'abbreviation' => 'SUB1_AGP',
            'description'=> 'Subgrupo de Equipo 1 de AGP',
            'active' => true,
        ]);

        Subgroup::create([
            'group_id' => 12,
            'abbreviation' => 'SUB2_AGP',
            'description'=> 'Subgrupo de Equipo 2 de AGP',
            'active' => true,
        ]);

        Subgroup::create([
            'group_id' => 20,
            'abbreviation' => 'SUB_ESP_ADR',
            'description'=> 'Subgrupo de Especialista ADR',
            'active' => true,
        ]);

        Subgroup::create([
            'group_id' => 21,
            'abbreviation' => 'SUB_ESP_AAJ',
            'description'=> 'Subgrupo de Especialista AAJ',
            'active' => true,
        ]);
    }
}
