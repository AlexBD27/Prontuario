<?php

namespace Database\Seeders;

use App\Models\AreaGroupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaGroupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        //OCI
        AreaGroupType::create([
            'area_id' => 1,
            'group_type_id' => 1,
            'active' => true,
        ]);

        AreaGroupType::create([
            'area_id' => 1,
            'group_type_id' => 2,
            'active' => true,
        ]);

        AreaGroupType::create([
            'area_id' => 1,
            'group_type_id' => 3,
            'active' => true,
        ]);*/

        AreaGroupType::create([
            'id' => 4,
            'area_id' => 1,
            'group_type_id' => 4,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 5,
            'area_id' => 1,
            'group_type_id' => 5,
            'active' => true,
        ]);

        //AGI
        AreaGroupType::create([
            'id' => 6,
            'area_id' => 2,
            'group_type_id' => 1,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 7,
            'area_id' => 2,
            'group_type_id' => 2,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 8,
            'area_id' => 2,
            'group_type_id' => 3,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 9,
            'area_id' => 2,
            'group_type_id' => 4,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 10,
            'area_id' => 2,
            'group_type_id' => 5,
            'active' => true,
        ]);

        //AGP
        AreaGroupType::create([
            'id' => 11,
            'area_id' => 3,
            'group_type_id' => 1,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 12,
            'area_id' => 3,
            'group_type_id' => 2,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 13,
            'area_id' => 3,
            'group_type_id' => 3,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 14,
            'area_id' => 3,
            'group_type_id' => 4,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 15,
            'area_id' => 3,
            'group_type_id' => 5,
            'active' => true,
        ]);

        //ADR
        AreaGroupType::create([
            'id' => 16,
            'area_id' => 4,
            'group_type_id' => 1,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 17,
            'area_id' => 4,
            'group_type_id' => 2,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 18,
            'area_id' => 4,
            'group_type_id' => 3,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 19,
            'area_id' => 4,
            'group_type_id' => 4,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 20,
            'area_id' => 4,
            'group_type_id' => 5,
            'active' => true,
        ]);

        //DIR
        AreaGroupType::create([
            'id' => 21,
            'area_id' => 5,
            'group_type_id' => 1,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 22,
            'area_id' => 5,
            'group_type_id' => 2,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 23,
            'area_id' => 5,
            'group_type_id' => 3,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 24,
            'area_id' => 5,
            'group_type_id' => 4,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 25,
            'area_id' => 5,
            'group_type_id' => 5,
            'active' => true,
        ]);

        //AAJ
        AreaGroupType::create([
            'id' => 26,
            'area_id' => 6,
            'group_type_id' => 1,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 27,
            'area_id' => 6,
            'group_type_id' => 2,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 28,
            'area_id' => 6,
            'group_type_id' => 3,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 29,
            'area_id' => 6,
            'group_type_id' => 4,
            'active' => true,
        ]);

        AreaGroupType::create([
            'id' => 30,
            'area_id' => 6,
            'group_type_id' => 5,
            'active' => true,
        ]);
    }
}
