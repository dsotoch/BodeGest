<?php

namespace Database\Seeders;

use App\Models\empresas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrearEmpresas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        empresas::create([
            'nombre'=>'BodeGest',
            'logo'=>'Bodegest',
            
        ]);
    }
}
