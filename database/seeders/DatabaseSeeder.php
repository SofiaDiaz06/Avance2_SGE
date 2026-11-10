<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,
            RolePermissionSeeder::class,
            CompanySettingSeeder::class, // Añadido para inicializar la identidad corporativa
            CategorySeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
            ProviderSeeder::class,
            TestUserSeeder::class,
        ]);
    }
}