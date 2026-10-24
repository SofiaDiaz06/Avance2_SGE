<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['document_type' => 'NIT', 'document_number' => '900111222', 'name' => 'Editorial y Papelera Norma SAS', 'contact_name' => 'Laura Ríos', 'email' => 'ventas@normapapeleria.com', 'phone' => '6012345678', 'address' => 'Bogotá, Calle 80 #45-12'],
            ['document_type' => 'NIT', 'document_number' => '900333444', 'name' => 'Importadora Escolar Andina', 'contact_name' => 'Pedro Salazar', 'email' => 'pedidos@escolarandina.com', 'phone' => '6044567890', 'address' => 'Medellín, Carrera 43A #1-50'],
            ['document_type' => 'NIT', 'document_number' => '900555666', 'name' => 'Distribuidora de Esferos y Tintas BIC', 'contact_name' => 'Diana Mejía', 'email' => 'comercial@biccolombia.com', 'phone' => '6027654321', 'address' => 'Cali, Av. 6N #23-45'],
            ['document_type' => 'CC', 'document_number' => '1094555666', 'name' => 'Andrés Cardona (Proveedor Local)', 'contact_name' => null, 'email' => 'andres.cardona@test.com', 'phone' => '3135556677', 'address' => 'Cartago, Calle 12 #5-30'],
            ['document_type' => 'NIT', 'document_number' => '900777888', 'name' => 'Papelera Nacional S.A.', 'contact_name' => 'Carlos Vives', 'email' => 'ventas@papeleranacional.com', 'phone' => '6028883344', 'address' => 'Palmira, Zona Industrial'],
            ['document_type' => 'NIT', 'document_number' => '900222333', 'name' => 'Comercializadora Escolar del Valle', 'contact_name' => 'Sofía Vergara', 'email' => 'contacto@escorvalle.com', 'phone' => '6025554433', 'address' => 'Tuluá, Calle 25 #10-12'],
            ['document_type' => 'NIT', 'document_number' => '900444555', 'name' => 'Suministros de Oficina y Arte S.A.', 'contact_name' => 'Esteban Quito', 'email' => 'pedidos@suministrosarte.com', 'phone' => '6017776655', 'address' => 'Bogotá, Carrera 68 #20-15'],
            ['document_type' => 'NIT', 'document_number' => '900666777', 'name' => 'Distribuciones Faber-Castell Colombia', 'contact_name' => 'Mariana Pajón', 'email' => 'comercial@fabercastell.com.co', 'phone' => '6014443322', 'address' => 'Bogotá, Autopista Norte #100-20'],
            ['document_type' => 'CC', 'document_number' => '1033221144', 'name' => 'Martha Lucía Herrera (Proveedor Local)', 'contact_name' => null, 'email' => 'martha.herrera@test.com', 'phone' => '3146667788', 'address' => 'Cartago, Carrera 4 #9-15'],
            ['document_type' => 'NIT', 'document_number' => '900888999', 'name' => 'Importaciones y Librerías del Sur', 'contact_name' => 'Jorge Cárdenas', 'email' => 'info@libreriasdelsur.com', 'phone' => '6023332211', 'address' => 'Pasto, Calle 18 #25-30'],
        ];

        foreach ($providers as $provider) {
            Provider::firstOrCreate(['document_number' => $provider['document_number']], $provider);
        }
    }
}