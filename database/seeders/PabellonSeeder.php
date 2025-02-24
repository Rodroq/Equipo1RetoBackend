<?php

namespace Database\Seeders;

use App\Models\Pabellon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PabellonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pabellon::create([
            'nombre' => 'Pabellon La Habana Vieja'
        ]);
    }
}
