<?php

namespace Database\Seeders;

use App\Models\planes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class crearPlanes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        planes::create([
            'nombre'=>'PLAN FACTURADOR',
            'precio'=>'37'
        ]);
        planes::create([
            'nombre'=>'PLAN BASICO',
            'precio'=>'22'
        ]);
    }
}
