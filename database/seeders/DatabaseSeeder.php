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
            CategorySeeder::class,
            ProductSeeder::class,
            ClientSeeder::class,
            ProviderSeeder::class,
            TestUserSeeder::class,
        ]);
    }
}