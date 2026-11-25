<?php

namespace Tests\Feature;

use App\Events\SaleCompleted;
use App\Events\SaleRegistered;
use App\Models\Client;
use App\Models\Module;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EventosVentasTest extends TestCase
{
    use RefreshDatabase;

    private User $vendedor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(RolePermissionSeeder::class);
        $this->activarModulosParaPruebas();
        $this->vendedor = User::factory()->create(['active' => true])->assignRole('vendedor');
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

    public function test_registrar_venta_dispara_evento_de_venta(): void
    {
        // Preparar
        Event::fake([SaleRegistered::class, SaleCompleted::class]);
        $product = Product::factory()->create(['price' => 50000, 'stock' => 10]);
        $client = Client::factory()->create();

        // Ejecutar
        $this->session(['active_role' => 'vendedor']);
        $response = $this->actingAs($this->vendedor)->post(route('sales.store'), [
            'client_id' => $client->id,
            'sale_date' => now()->toDateString(),
            'items' => [['product_id' => $product->id, 'quantity' => 2]],
        ]);

        // Verificar
        $response->assertRedirect();
        $this->assertTrue(
            Event::dispatched(SaleRegistered::class)->isNotEmpty()
            || Event::dispatched(SaleCompleted::class)->isNotEmpty()
        );
    }
}
