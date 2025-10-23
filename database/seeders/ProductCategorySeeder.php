<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Paletaria',
            'Pasteles',
            'Conos',
            'Especializados',
            'Extras',
            'Bebidas',
            'Bebidas Frias',
        ];

        foreach ($categories as $category) {
            ProductCategory::create(['description' => $category]);
        }
    }
}
