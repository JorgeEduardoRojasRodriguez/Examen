<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contactos;
use App\Models\Telefonos;
use App\Models\Emails;
use App\Models\Direcciones;
use Illuminate\Support\Facades\DB;

class ContactosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Se generan 5000 contactos
        for ($i = 0; $i < 5000; $i++) {
            $contacto = Contactos::factory()->create();

            // Se generan 5 telefonos para cada contacto
            for ($j = 0; $j < 5; $j++) {
                Telefonos::factory()->create([
                    'contacto_id' => $contacto->id,
                ]);
            }

            // Se generan 5 emails para cada contacto
            for ($j = 0; $j < 5; $j++) {
                Emails::factory()->create([
                    'contacto_id' => $contacto->id,
                ]);
            }

            // Se generan 5 direcciones para cada contacto
            for ($j = 0; $j < 5; $j++) {
                Direcciones::factory()->create([
                    'contacto_id' => $contacto->id,
                ]);
            }
        }

        
        
    }
}
