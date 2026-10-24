<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['key' => 'categories', 'name' => 'Categorías', 'is_active' => true],
            ['key' => 'products', 'name' => 'Productos', 'is_active' => true],
            ['key' => 'clients', 'name' => 'Clientes', 'is_active' => true],
            ['key' => 'providers', 'name' => 'Proveedores', 'is_active' => true],
            ['key' => 'sales', 'name' => 'Ventas', 'is_active' => true],
            ['key' => 'purchases', 'name' => 'Compras', 'is_active' => true],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(['key' => $module['key']], $module);
        }
    }
}