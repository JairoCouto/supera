<?php

use Illuminate\Database\Seeder;
use App\Models\Atestado\Atestado;
use Illuminate\Support\Str;

class AtestadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Atestado::create([
            'codigo_atestado' => rand(5,15),
            'paciente' => Str::random(10)
        ]);
    }
}
