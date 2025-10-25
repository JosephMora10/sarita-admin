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
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test',
                'lastname' => 'User',
                'phone' => '12345678',
                'role' => true,
                'password' => 'password',
            ]
        );

        if (ProductCategory::count() === 0) {
            $this->call(ProductCategorySeeder::class);
        }

        if (Product::count() === 0) {
            $this->call(ProductSeeder::class);
        }

        if (PaymentMethod::count() === 0) {
            $this->call(PaymentMethodSeeder::class);
        }

        $this->command->info('Database seeded successfully!');
    }
}