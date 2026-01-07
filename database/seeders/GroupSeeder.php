<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        Group::create([
            'area_group_type_id' => 1,
            'abbreviation' => 'SEC_OCI',
            'description'=> 'Secretaria de OCI',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 8,
            'abbreviation' => 'EQU1_AGI',
            'description'=> 'Equipo 1 de AGI',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 8,
            'abbreviation' => 'EQU2_AGI',
            'description'=> 'Equipo 2 de AGI',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 6,
            'abbreviation' => 'SEC_AGI',
            'description'=> 'Secretaria de AGI',
            'active' => true,
        ]);*/

        Group::create([
            'area_group_type_id' => 11,
            'abbreviation' => 'SEC_AGP',
            'description'=> 'Secretaria de AGP',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 16,
            'abbreviation' => 'SEC_ADR',
            'description'=> 'Secretaria de ADR',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 21,
            'abbreviation' => 'SEC_DIR',
            'description'=> 'Secretaria de DIR',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 26,
            'abbreviation' => 'SEC_AAJ',
            'description'=> 'Secretaria de AAJ',
            'active' => true,
        ]);



        Group::create([
            'area_group_type_id' => 3,
            'abbreviation' => 'EQU1_OCI',
            'description'=> 'Equipo 1 de OCI',
            'active' => true,
        ]);
        Group::create([
            'area_group_type_id' => 3,
            'abbreviation' => 'EQU2_OCI',
            'description'=> 'Equipo 2 de OCI',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 13,
            'abbreviation' => 'EQU1_AGP',
            'description'=> 'Equipo 1 de AGP',
            'active' => true,
        ]);
        Group::create([
            'area_group_type_id' => 13,
            'abbreviation' => 'EQU2_AGP',
            'description'=> 'Equipo 2 de AGP',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 18,
            'abbreviation' => 'EQU1_ADR',
            'description'=> 'Equipo 1 de ADR',
            'active' => true,
        ]);
        Group::create([
            'area_group_type_id' => 18,
            'abbreviation' => 'EQU2_ADR',
            'description'=> 'Equipo 2 de ADR',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 28,
            'abbreviation' => 'EQU1_AAJ',
            'description'=> 'Equipo 1 de AAJ',
            'active' => true,
        ]);
        Group::create([
            'area_group_type_id' => 28,
            'abbreviation' => 'EQU2_AAJ',
            'description'=> 'Equipo 2 de AAJ',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 5,
            'abbreviation' => 'ESP_OCI',
            'description'=> 'Especialista 1 de OCI',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 10,
            'abbreviation' => 'ESP_AGI',
            'description'=> 'Especialista 1 de AGI',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 15,
            'abbreviation' => 'ESP_AGP',
            'description'=> 'Especialista 1 de AGP',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 20,
            'abbreviation' => 'ESP_ADR',
            'description'=> 'Especialista 1 de ADR',
            'active' => true,
        ]);

        Group::create([
            'area_group_type_id' => 30,
            'abbreviation' => 'ESP_AAJ',
            'description'=> 'Especialista 1 de AAJ',
            'active' => true,
        ]);
    }
}
