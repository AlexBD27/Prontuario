<?php

namespace Database\Seeders;

use App\Models\GiroType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiroTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GiroType::create([
            'abbreviation' => 'INT',
            'description' => 'INTERNO',
            'active' => true,
        ]);

        GiroType::create([
            'abbreviation' => 'EXT',
            'description' => 'EXTERNO',
            'active' => true,
        ]);

        GiroType::create([
            'abbreviation' => 'PUB',
            'description' => 'PÚBLICO',
            'active' => true,
        ]);
    }
}
