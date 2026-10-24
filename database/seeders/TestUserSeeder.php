<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Administrador', 'email' => 'admin@test.com', 'roles' => ['admin'], 'direct' => []],
            ['name' => 'Vendedor', 'email' => 'vendedor@test.com', 'roles' => ['vendedor'], 'direct' => []],
            ['name' => 'Almacenista', 'email' => 'almacenista@test.com', 'roles' => ['almacenista'], 'direct' => []],
            ['name' => 'Supervisor', 'email' => 'supervisor@test.com', 'roles' => ['vendedor', 'almacenista'], 'direct' => ['ver-reportes']],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], [
                'name' => $data['name'],
                'password' => 'password',
            ]);
            $user->forceFill(['email_verified_at' => $user->email_verified_at ?? now()])->save();
            $user->syncRoles($data['roles']);
            $user->syncPermissions($data['direct']);
        }
    }
}