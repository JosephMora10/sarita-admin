<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            'Efectivo',
            'Tarjeta de Credito',
            'Transferencia',
        ];

        foreach ($methods as $method) {
            PaymentMethod::create(['description' => $method]);
        }
    }
}
