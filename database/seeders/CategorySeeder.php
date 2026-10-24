<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Cuadernos y Libretas', 'description' => 'Cuadernos argollados, cosidos y libretas de apuntes'],
            ['name' => 'Escritura', 'description' => 'Bolígrafos, lápices, borradores y resaltadores'],
            ['name' => 'Papel y Cartón', 'description' => 'Resmas de papel bond, cartulinas y papeles especiales'],
            ['name' => 'Archivo y Organización', 'description' => 'Carpetas, archivadores, ganchos y perforadoras'],
            ['name' => 'Arte y Manualidades', 'description' => 'Pinturas, pinceles, foami y tijeras escolares'],
            ['name' => 'Geometría y Dibujo', 'description' => 'Reglas, compases, escuadras y lápices técnicos'],
            ['name' => 'Adhesivos y Cintas', 'description' => 'Pegamentos en barra, líquidos y cintas adhesivas'],
            ['name' => 'Mochilas y Cartucheras', 'description' => 'Morrales escolares y estuches para lápices'],
            ['name' => 'Tecnología Escolar', 'description' => 'Calculadoras científicas y memorias USB'],
            ['name' => 'Didácticos y Juegos', 'description' => 'Rompecabezas, plastilinas y material pedagógico'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}