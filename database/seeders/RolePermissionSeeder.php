<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Crea (o actualiza) permisos y roles. Se puede ejecutar varias veces sin duplicar registros.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'ver-productos', 'crear-productos', 'editar-productos', 'eliminar-productos',
            'ver-categorias', 'crear-categorias', 'editar-categorias', 'eliminar-categorias',
            'ver-clientes', 'crear-clientes', 'editar-clientes', 'eliminar-clientes',
            'ver-ventas', 'crear-ventas', 'editar-ventas', 'eliminar-ventas',
            'ver-proveedores', 'crear-proveedores', 'editar-proveedores', 'eliminar-proveedores',
            'ver-compras', 'crear-compras', 'editar-compras', 'eliminar-compras', 'recibir-compras',
            'ver-reportes',
            'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
            'ver-roles', 'crear-roles', 'editar-roles', 'eliminar-roles',
            'ver-permisos', 'crear-permisos', 'eliminar-permisos',
            // Inventario (kardex) y auditoría (Clase 12)
            'ver-inventario', 'ajustar-inventario',
            'ver-auditoria',
            // Identidad corporativa (guía de configuración visual)
            'ver-branding', 'editar-branding',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // El administrador siempre tiene TODOS los permisos
        Role::findOrCreate('admin')->syncPermissions(Permission::all());

        Role::findOrCreate('vendedor')->syncPermissions([
            'ver-productos',
            'ver-clientes', 'crear-clientes', 'editar-clientes',
            'ver-ventas', 'crear-ventas',
        ]);

        Role::findOrCreate('almacenista')->syncPermissions([
            'ver-productos', 'crear-productos', 'editar-productos',
            'ver-categorias',
            'ver-proveedores', 'crear-proveedores', 'editar-proveedores',
            'ver-compras', 'crear-compras', 'recibir-compras',
            'ver-inventario', 'ajustar-inventario',
        ]);
    }
}