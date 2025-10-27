<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            if (!Schema::hasColumn('daily_sales', 'items_qty')) {
                $table->integer('items_qty')->default(0)->after('id');
            }
            if (!Schema::hasColumn('daily_sales', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0)->after('items_qty');
            }
            if (!Schema::hasColumn('daily_sales', 'seller_id')) {
                $table->integer('seller_id')->after('total_amount');
            }
            if (!Schema::hasColumn('daily_sales', 'is_completed')) {
                $table->boolean('is_completed')->default(false)->after('seller_id');
            }

            if (Schema::hasColumn('daily_sales', 'product_id')) {
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('daily_sales', 'product_price')) {
                $table->dropColumn('product_price');
            }
        });

        if (!Schema::hasTable('daily_sale_details')) {
            Schema::create('daily_sale_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('daily_sale_id')->constrained('daily_sales')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products');
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 10, 2)->default(0);
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('daily_sale_details')) {
            Schema::dropIfExists('daily_sale_details');
        }

        Schema::table('daily_sales', function (Blueprint $table) {
            if (!Schema::hasColumn('daily_sales', 'product_id')) {
                $table->integer('product_id')->nullable()->after('seller_id');
            }
            if (!Schema::hasColumn('daily_sales', 'product_price')) {
                $table->decimal('product_price', 10, 2)->nullable()->after('product_id');
            }

            if (Schema::hasColumn('daily_sales', 'items_qty')) {
                $table->dropColumn('items_qty');
            }
            if (Schema::hasColumn('daily_sales', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('daily_sales', 'seller_id')) {
                $table->dropColumn('seller_id');
            }
            if (Schema::hasColumn('daily_sales', 'is_completed')) {
                $table->dropColumn('is_completed');
            }
        });
    }
};
