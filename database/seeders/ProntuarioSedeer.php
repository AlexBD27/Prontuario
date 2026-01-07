<?php

namespace Database\Seeders;

use App\Giro;
use App\Models\Prontuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProntuarioSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prontuario::create([
            'worker_id' => 1,
            'giro_type' => Giro::Internal,
            'doc_type_id' => 1,
            'number' => 1,
            'folios' =>'2',
            'date' => date('2024-04-12'),
            'period' => '2024',
            'month' => 4,
            'reset' => 1
        ]);

        Prontuario::create([
            'worker_id' => 2,
            'giro_type' => Giro::Internal,
            'doc_type_id' => 2,
            'number' => 1,
            'folios' => '3',
            'date' => date('2024-05-15'),
            'period' => '2024',
            'month' => 5,
            'reset' => 1
        ]);

        Prontuario::create([
            'worker_id' => 1,
            'giro_type' => Giro::Internal,
            'doc_type_id' => 1,
            'number' => 2,
            'folios' => '2',
            'date' => date('2024-06-21'),
            'period' => '2024',
            'month' => 6,
            'reset' => 1
        ]);

        Prontuario::create([
            'worker_id' => 2,
            'giro_type' => Giro::External,
            'doc_type_id' => 5,
            'number' => 1,
            'folios' => '1',
            'date' => date('2024-07-27'),
            'period' => '2024',
            'month' => 7,
            'reset' => 1
        ]);

        Prontuario::create([
            'worker_id' => 3,
            'giro_type' => Giro::External,
            'doc_type_id' => 7,
            'number' => 1,
            'folios' => '1',
            'date' => date('2024-08-7'),
            'period' => '2024',
            'month' => 8,
            'reset' => 1
        ]);
    }
}
