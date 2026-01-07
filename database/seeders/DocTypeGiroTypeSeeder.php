<?php

namespace Database\Seeders;

use App\Models\DocTypeGiroType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocTypeGiroTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocTypeGiroType::create([
            'id' => 1,
            'doc_type_id' => 1,
            'giro_type_id' => 1,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 2,
            'doc_type_id' => 1,
            'giro_type_id' => 2,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 3,
            'doc_type_id' => 2,
            'giro_type_id' => 1,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 4,
            'doc_type_id' => 2,
            'giro_type_id' => 2,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 5,
            'doc_type_id' => 3,
            'giro_type_id' => 1,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 6,
            'doc_type_id' => 4,
            'giro_type_id' => 1,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 7,
            'doc_type_id' => 5,
            'giro_type_id' => 2,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 8,
            'doc_type_id' => 6,
            'giro_type_id' => 2,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 9,
            'doc_type_id' => 7,
            'giro_type_id' => 3,
            'active' => 1,
        ]);

        DocTypeGiroType::create([
            'id' => 10,
            'doc_type_id' => 16,
            'giro_type_id' => 3,
            'active' => 1,
        ]);
    }
}
