<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // 🧊 PALETERÍA
            ['description' => 'Cinta Negra', 'price' => 8.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Paletas de Fruta de Hielo', 'price' => 8.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Paleta de Sandía', 'price' => 7.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Sorbi Twist', 'price' => 7.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Sandwich', 'price' => 8.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Sandwchichito', 'price' => 8.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Giga Almendra y Clásico', 'price' => 12.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Helados Caseros', 'price' => 8.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Cinta Negra Crispi', 'price' => 10.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Cremosas', 'price' => 6.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Copa Sundae Grande', 'price' => 12.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Vasito', 'price' => 6.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Cronchichop Fresa', 'price' => 10.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Caja de Giga 6 Unidades', 'price' => 72.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Caja Paleta de Fruta', 'price' => 48.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Caja de Sandwichito 6 Unidades', 'price' => 48.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Blok', 'price' => 8.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Envasados', 'price' => 55.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Medio Galón', 'price' => 55.00, 'stock' => 100, 'category_id' => 1],
            ['description' => 'Litro', 'price' => 35.00, 'stock' => 100, 'category_id' => 1],

            // 🍰 PASTELES
            ['description' => 'Pastel de 12 Porciones', 'price' => 120.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Pastel de 16 Porciones', 'price' => 160.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Porción', 'price' => 22.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Sarita Shake', 'price' => 16.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Chocolate para Derretir Pequeño', 'price' => 16.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Chocolate para Derretir Grande', 'price' => 30.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Barra de Giga', 'price' => 8.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Barrita de Giga', 'price' => 8.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Choco Cremita', 'price' => 2.50, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Chococoncito', 'price' => 1.50, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Caja de 10 Conos', 'price' => 15.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Bolsa de Cono Grande', 'price' => 20.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Caja de Canasta', 'price' => 18.00, 'stock' => 50, 'category_id' => 2],
            ['description' => 'Paquete de Galleta Redonda', 'price' => 12.00, 'stock' => 50, 'category_id' => 2],

            // 🍦 CONOS
            ['description' => 'Cono Sencillo', 'price' => 12.00, 'stock' => 100, 'category_id' => 3],
            ['description' => 'Cono Doble', 'price' => 18.00, 'stock' => 100, 'category_id' => 3],
            ['description' => 'Capuchino', 'price' => 16.00, 'stock' => 100, 'category_id' => 3],
            ['description' => 'Capuchino Doble', 'price' => 21.00, 'stock' => 100, 'category_id' => 3],
            ['description' => 'Wafle Topping', 'price' => 16.00, 'stock' => 100, 'category_id' => 3],

            // 🍨 ESPECIALIZADOS
            ['description' => 'Bomba', 'price' => 32.00, 'stock' => 100, 'category_id' => 4],
            ['description' => 'Banana', 'price' => 30.00, 'stock' => 100, 'category_id' => 4],
            ['description' => 'Canasta Wafle', 'price' => 26.00, 'stock' => 100, 'category_id' => 4],
            ['description' => 'Sundae Especial', 'price' => 28.00, 'stock' => 100, 'category_id' => 4],
            ['description' => 'Sundae Galleta', 'price' => 24.00, 'stock' => 100, 'category_id' => 4],
            ['description' => 'Topping Sundae', 'price' => 20.00, 'stock' => 100, 'category_id' => 4],
            ['description' => 'Bola de Helado', 'price' => 8.00, 'stock' => 100, 'category_id' => 4],

            // 🍫 EXTRAS
            ['description' => 'Chocolate', 'price' => 3.00, 'stock' => 100, 'category_id' => 5],
            ['description' => 'Manía', 'price' => 2.00, 'stock' => 100, 'category_id' => 5],
            ['description' => 'Anicillo', 'price' => 2.00, 'stock' => 100, 'category_id' => 5],

            // 🥤 BEBIDAS
            ['description' => 'Agua Pura Salvavidas', 'price' => 6.00, 'stock' => 100, 'category_id' => 6],
            ['description' => 'Coca-Cola', 'price' => 8.00, 'stock' => 100, 'category_id' => 6],
            ['description' => 'Otros Sabores', 'price' => 6.00, 'stock' => 100, 'category_id' => 6],

            // 🧋 BEBIDAS FRÍAS
            ['description' => 'Nevada', 'price' => 28.00, 'stock' => 100, 'category_id' => 7],
            ['description' => 'Milk Shake Sencillo', 'price' => 26.00, 'stock' => 100, 'category_id' => 7],
            ['description' => 'Milk Shake con Crema Batida', 'price' => 28.00, 'stock' => 100, 'category_id' => 7],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
