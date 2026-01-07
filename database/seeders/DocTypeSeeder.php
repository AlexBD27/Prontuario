<?php

namespace Database\Seeders;

use App\Models\DocType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocType::create([
            'abbreviation' => 'OF',
            'description'=> 'Oficio',
            'active'=> true,
        ]);

        DocType::create([
            'abbreviation' => 'OFMUL',
            'description'=> 'Oficio Múltiple',
            'active'=> true,
        ]);
        
        DocType::create([
            'abbreviation' => 'MEMO',
            'description'=> 'Memorandum',
            'active'=> true,
        ]);

        DocType::create([
            'abbreviation' => 'MEMOMUL',
            'description'=> 'Memorandum Múltiple',
            'active'=> true,
        ]);

        DocType::create([
            'abbreviation' => 'CAR',
            'description'=> 'Carta',
            'active'=> true,
        ]);

        DocType::create([
            'abbreviation' => 'DIRE',
            'description'=> 'Directiva',
            'active'=> true,
        ]);

        DocType::create([
            'abbreviation' => 'PROY',
            'description'=> 'Proyecto',
            'active'=> true,
        ]);
    }
}
