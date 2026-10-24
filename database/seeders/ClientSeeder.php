<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['document_type' => 'CC', 'document_number' => '1088123456', 'name' => 'Juan Pérez (Papelería Escolar)', 'email' => 'juan@test.com', 'phone' => '3001234567', 'address' => 'Calle 10 #20-30'],
            ['document_type' => 'NIT', 'document_number' => '900123456', 'name' => 'Colegio y Librería El Saber SAS', 'email' => 'contacto@elsaber.com', 'phone' => '3109876543', 'address' => 'Carrera 5 #45-10'],
            ['document_type' => 'CC', 'document_number' => '1098765432', 'name' => 'María Gómez', 'email' => 'maria@test.com', 'phone' => '3201112233', 'address' => 'Av. Principal #12-34'],
            ['document_type' => 'CE', 'document_number' => 'E1234567', 'name' => 'Carlos Rodríguez', 'email' => 'carlos@test.com', 'phone' => '3154445566', 'address' => 'Transversal 8 #90-12'],
            ['document_type' => 'NIT', 'document_number' => '900456789', 'name' => 'Librería Universitaria S.A.S.', 'email' => 'ventas@libreriauniv.com', 'phone' => '6023334455', 'address' => 'Calle 15 #3-22'],
            ['document_type' => 'CC', 'document_number' => '1077889900', 'name' => 'Ana Sofía Torres', 'email' => 'ana.torres@test.com', 'phone' => '3112223344', 'address' => 'Carrera 12 #8-40'],
            ['document_type' => 'NIT', 'document_number' => '900789123', 'name' => 'Fundación Educativa Crecer', 'email' => 'compras@fundecreer.org', 'phone' => '6015558899', 'address' => 'Diagonal 23 #50-12'],
            ['document_type' => 'CC', 'document_number' => '1066554433', 'name' => 'Luis Fernando Ospina', 'email' => 'luis.ospina@test.com', 'phone' => '3187778899', 'address' => 'Calle 4 #11-20'],
            ['document_type' => 'CC', 'document_number' => '1055443322', 'name' => 'Marcela Benítez', 'email' => 'marcela@test.com', 'phone' => '3169990011', 'address' => 'Avenida 3N #15-45'],
            ['document_type' => 'NIT', 'document_number' => '900999888', 'name' => 'Comercializadora de Textos y Más', 'email' => 'info@textosymas.com', 'phone' => '6048881122', 'address' => 'Carrera 43 #50-25'],
        ];

        foreach ($clients as $client) {
            Client::firstOrCreate(['document_number' => $client['document_number']], $client);
        }
    }
}