<?php

namespace Tests\Feature;

use App\Models\Module;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PermisosPorRolTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(RolePermissionSeeder::class);
        $this->activarModulosParaPruebas();
    }

    private function activarModulosParaPruebas(): void
    {
        if (! Schema::hasTable('modules')) {
            return;
        }

        $modulos = ['products', 'categories', 'clients', 'providers', 'sales', 'purchases', 'inventory', 'audit'];
        $keyColumn = Schema::hasColumn('modules', 'key')
            ? 'key'
            : (Schema::hasColumn('modules', 'slug') ? 'slug' : 'name');

        $activeColumn = Schema::hasColumn('modules', 'active')
            ? 'active'
            : (Schema::hasColumn('modules', 'enabled') ? 'enabled' : (Schema::hasColumn('modules', 'is_active') ? 'is_active' : null));

        $hasName = Schema::hasColumn('modules', 'name') && $keyColumn !== 'name';

        foreach ($modulos as $modulo) {
            $values = [];
            if ($activeColumn) {
                $values[$activeColumn] = true;
            }
            if ($hasName) {
                $values['name'] = ucfirst($modulo);
            }
            Module::query()->updateOrCreate([$keyColumn => $modulo], $values);
        }
    }

    public static function matriz(): array
    {
        return [
            ['admin', '/configuracion', 200],
            ['admin', '/auditoria', 200],
            ['vendedor', '/sales/create', 200],
            ['vendedor', '/purchases', 403],
            ['vendedor', '/configuracion', 403],
            ['vendedor', '/inventario/kardex', 403],
            ['almacenista', '/purchases/create', 200],
            ['almacenista', '/inventario/kardex', 200],
            ['almacenista', '/sales', 403],
            ['almacenista', '/auditoria', 403],
        ];
    }

    #[DataProvider('matriz')]
    public function test_acceso_por_rol(string $rol, string $url, int $esperado): void
    {
        $user = User::factory()->create(['active' => true])->assignRole($rol);

        $this->session(['active_role' => $rol]);
        $this->actingAs($user)->get($url)->assertStatus($esperado);
    }

    public function test_un_invitado_es_enviado_al_login(): void
    {
        $this->get('/sales')->assertRedirect('/login');
    }
}
