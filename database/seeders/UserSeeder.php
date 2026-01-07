<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
use App\Models\Worker;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*User::create([
            'name' => 'alex',
            'email' => 'gilmertiradoam.27@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        Worker::create([
            'user_id' => 1,
            'group_id' => 2,
            'subgroup_id' => 1,
            'name' => 'Alex Tirado Mendoza',
            'dni' => '73887937',
            'position' => 'Encargado de Equipo',
        ]);



        User::create([
            'name' => 'pablo',
            'email' => 'pablo514@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        Worker::create([
            'user_id' => 2,
            'group_id' => 3,
            'subgroup_id' => 2,
            'name' => 'Pablo Fernández García',
            'dni' => '85436915',
            'position' => 'Encargado de Equipo',
        ]);

        User::create([
            'name' => 'Sofía',
            'email' => 'sofia72@gmail.com',
            'password' => Hash::make('987654321'),
        ]);

        Worker::create([
            'user_id' => 3,
            'group_id' => 1,
            'subgroup_id' => null,
            'name' => 'Sofía López Cano',
            'dni' => '52765418',
            'position' => 'Encargada de Secretaría ',
        ]);

        User::create([
            'name' => 'jose',
            'email' => 'josemontalvo@gmail.com',
            'password' => Hash::make('josemontalvo'),
        ]);

        Person::create([
            'name'=> 'Jose',
            'lastname' => 'Montalvo',
            'dni' => '57812496',
            'phone_number' => '958145237',
            'user_id' => 4
        ]);

        User::create([
            'name' => 'Hugo',
            'email' => 'hugosaavedra@gmail.com',
            'password' => Hash::make('hugosaavedra'),
        ]);

        Person::create([
            'name'=> 'Hugo',
            'lastname' => 'Saavedra',
            'dni' => '72548261',
            'phone_number' => '928146201',
            'user_id' => 5
        ]);

        User::create([
            'name' => 'Benny',
            'email' => 'bennyvalentin@gmail.com',
            'password' => Hash::make('bennyvalentin'),
        ]);

        Person::create([
            'name'=> 'Benny',
            'lastname' => 'Valentin',
            'dni' => '72846951',
            'phone_number' => '928465137',
            'user_id' => 6
        ]);

        Person::create([
            'name'=> 'Alex',
            'lastname' => 'Tirado',
            'dni' => '73887937',
            'phone_number' => '928207628',
            'user_id' => 1
        ]);

        Person::create([
            'name'=> 'Pablo',
            'lastname' => 'Lopez',
            'dni' => '8245716',
            'phone_number' => '957412863',
            'user_id' => 2
        ]);

        Person::create([
            'name'=> 'Sofia',
            'lastname' => 'Nunez',
            'dni' => '48517952',
            'phone_number' => '928745167',
            'user_id' => 3
        ]); */

        Worker::create([
            'group_id' => 4,
            'subgroup_id' => null,
            'name' => 'Alexis Novoa',
            'dni' => '75486259',
            'position' => 'Encargado de Secretaría AGI',
        ]);

        Worker::create([
            'group_id' => 5,
            'subgroup_id' => null,
            'name' => 'Milenka Nolasco',
            'dni' => '75486259',
            'position' => 'Encargada de Secretaría AGP',
        ]);

        Worker::create([
            'group_id' => 6,
            'subgroup_id' => null,
            'name' => 'Noelia Carrasco',
            'dni' => '75486259',
            'position' => 'Encargada de Secretaría ADR',
        ]);

        Worker::create([
            'group_id' => 7,
            'subgroup_id' => null,
            'name' => 'Zully Andrade',
            'dni' => '75486259',
            'position' => 'Encargada de Secretaría DIR',
        ]);

        Worker::create([
            'group_id' => 8,
            'subgroup_id' => null,
            'name' => 'Dalia Moreno',
            'dni' => '75486259',
            'position' => 'Encargada de Secretaría AAJ',
        ]);

        Worker::create([
            'group_id' => 2,
            'subgroup_id' => null,
            'name' => 'Alonso Molina',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 1 de AGI',
        ]);

        Worker::create([
            'group_id' => 3,
            'subgroup_id' => null,
            'name' => 'Nando Fernandez',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 2 de AGI',
        ]);

        Worker::create([
            'group_id' => 9,
            'subgroup_id' => 3,
            'name' => 'Marla Antonia',
            'dni' => '75486259',
            'position' => 'Encargada de Equipo 1 de OCI',
        ]);

        Worker::create([
            'group_id' => 10,
            'subgroup_id' => 4,
            'name' => 'Julia Rojas',
            'dni' => '75486259',
            'position' => 'Encargada de Equipo 2 de OCI',
        ]);

        Worker::create([
            'group_id' => 11,
            'subgroup_id' => 5,
            'name' => 'Marlon Escobedo',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 1 de AGP',
        ]);

        Worker::create([
            'group_id' => 12,
            'subgroup_id' => 6,
            'name' => 'Junior Fuad',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 2 de AGP',
        ]);

        Worker::create([
            'group_id' => 13,
            'subgroup_id' => null,
            'name' => 'Luka Modric',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 1 de ADR',
        ]);

        Worker::create([
            'group_id' => 14,
            'subgroup_id' => null,
            'name' => 'Rodrigo Goes',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 2 de ADR',
        ]);

        Worker::create([
            'group_id' => 15,
            'subgroup_id' => null,
            'name' => 'Dani Carvajal',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 1 de AAJ',
        ]);

        Worker::create([
            'group_id' => 16,
            'subgroup_id' => null,
            'name' => 'Eder Militao',
            'dni' => '75486259',
            'position' => 'Encargado de Equipo 2 de AAJ',
        ]);

        Worker::create([
            'group_id' => 17,
            'subgroup_id' => 7,
            'name' => 'Lucho Diaz',
            'dni' => '75486259',
            'position' => 'Encargado Especialista de ADR',
        ]);

        Worker::create([
            'group_id' => 17,
            'subgroup_id' => 8,
            'name' => 'Lucho Diaz',
            'dni' => '75486259',
            'position' => 'Encargado Especialista de AAJ',
        ]);
    }
}
