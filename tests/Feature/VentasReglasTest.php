<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Module;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class VentasReglasTest extends TestCase
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

    private function vender(Product $product, int $cantidad, ?Client $client = null)
    {
        $this->session(['active_role' => 'vendedor']);

        return $this->actingAs($this->vendedor)->post(route('sales.store'), [
            'client_id' => ($client ?? Client::factory()->create())->id,
            'sale_date' => now()->toDateString(),
            'items' => [['product_id' => $product->id, 'quantity' => $cantidad]],
        ]);
    }

    public function test_la_venta_descuenta_el_stock_y_calcula_el_iva(): void
    {
        $product = Product::factory()->create(['price' => 100000, 'stock' => 10]);

        $this->vender($product, 3)->assertRedirect();

        $this->assertSame(7, $product->fresh()->stock);
        $this->assertDatabaseHas('sales', [
            'invoice_number' => 'FV-00001',
            'subtotal' => 300000,
            'tax' => 57000,
            'total' => 357000,
        ]);
    }

    public function test_no_se_vende_mas_del_stock_disponible(): void
    {
        $product = Product::factory()->create(['stock' => 2]);

        $this->vender($product, 5)->assertSessionHasErrors('items');
        $this->assertSame(2, $product->fresh()->stock);
        $this->assertDatabaseCount('sales', 0);
    }

    public function test_no_se_vende_a_un_cliente_inactivo(): void
    {
        $product = Product::factory()->create(['stock' => 5]);

        $this->vender($product, 1, Client::factory()->inactive()->create())
            ->assertSessionHasErrors('client_id');
    }

    public function test_anular_devuelve_el_stock(): void
    {
        $admin = User::factory()->create(['active' => true])->assignRole('admin');
        $product = Product::factory()->create(['stock' => 10]);
        $this->vender($product, 4);
        $sale = Sale::first();

        $this->session(['active_role' => 'admin']);
        $this->actingAs($admin)->delete(route('sales.destroy', $sale))->assertRedirect();

        $this->assertSame(10, $product->fresh()->stock);
        $this->assertSoftDeleted('sales', ['id' => $sale->id, 'status' => 'anulada']);
    }

    public function test_el_vendedor_no_puede_anular_ventas(): void
    {
        $product = Product::factory()->create(['stock' => 10]);
        $this->vender($product, 1);

        $this->session(['active_role' => 'vendedor']);
        $this->actingAs($this->vendedor)->delete(route('sales.destroy', Sale::first()))
            ->assertForbidden();
    }
}
