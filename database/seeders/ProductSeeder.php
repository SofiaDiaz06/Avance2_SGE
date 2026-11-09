<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(InventoryService $inventory): void
    {
        $cuadernos = Category::firstOrCreate(['name' => 'Cuadernos y Libretas'], ['description' => 'Cuadernos argollados y cosidos']);
        $escritura = Category::firstOrCreate(['name' => 'Escritura'], ['description' => 'Bolígrafos y lápices']);
        $papel = Category::firstOrCreate(['name' => 'Papel y Cartón'], ['description' => 'Papel bond y cartulinas']);
        $archivo = Category::firstOrCreate(['name' => 'Archivo y Organización'], ['description' => 'Carpetas y ganchos']);
        $arte = Category::firstOrCreate(['name' => 'Arte y Manualidades'], ['description' => 'Materiales escolares']);
        $geometria = Category::firstOrCreate(['name' => 'Geometría y Dibujo'], ['description' => 'Reglas y compases']);
        $adhesivos = Category::firstOrCreate(['name' => 'Adhesivos y Cintas'], ['description' => 'Pegamentos y cintas']);

        $products = [
            ['name' => 'Cuaderno Argollado 100 Hojas', 'price' => 8500, 'stock' => 120, 'category_id' => $cuadernos->id, 'active' => true],
            ['name' => 'Bolígrafo Negro BIC Cristal', 'price' => 1200, 'stock' => 300, 'category_id' => $escritura->id, 'active' => true],
            ['name' => 'Resma Papel Bond Carta 75g', 'price' => 22000, 'stock' => 45, 'category_id' => $papel->id, 'active' => true],
            ['name' => 'Carpeta Plástica con Ligas', 'price' => 4500, 'stock' => 80, 'category_id' => $archivo->id, 'active' => true],
            ['name' => 'Lápiz Mirado No. 2 Caja x 12', 'price' => 9500, 'stock' => 50, 'category_id' => $escritura->id, 'active' => true],
            ['name' => 'Tijeras Escolares Punta Redonda', 'price' => 3800, 'stock' => 60, 'category_id' => $arte->id, 'active' => true],
            ['name' => 'Resaltador Stabilo Boss', 'price' => 5200, 'stock' => 4, 'category_id' => $escritura->id, 'active' => true], // Stock bajo para KPIs
            ['name' => 'Juego de Geometría 5 Piezas', 'price' => 6000, 'stock' => 35, 'category_id' => $geometria->id, 'active' => true],
            ['name' => 'Cinta Adhesiva Transparente 19mm', 'price' => 2500, 'stock' => 90, 'category_id' => $adhesivos->id, 'active' => true],
            ['name' => 'Bloc de Hojas Milimetradas', 'price' => 4200, 'stock' => 25, 'category_id' => $papel->id, 'active' => true],
            ['name' => 'Corrector Líquido en Pincel', 'price' => 4800, 'stock' => 30, 'category_id' => $escritura->id, 'active' => true],
        ];

        foreach ($products as $product) {
            $model = Product::firstOrCreate(['name' => $product['name']], $product);
            
            // Clase 12: saldo inicial en el kardex para cada producto de la papelería[cite: 34, 35]
            $inventory->opening($model);[cite: 34, 35]
        }
    }
}