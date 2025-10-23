<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test',
            'lastname' => 'User',
            'phone' => '12345678',
            'email' => 'test@example.com',
            'role' => true,
        ]);

        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
