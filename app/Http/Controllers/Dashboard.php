<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    public function index(Request $request)
    {
        // Obtener fechas del filtro o usar valores por defecto
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Convertir a Carbon para consultas
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Estadísticas generales
        $totalSales = Order::whereBetween('orders.created_at', [$start, $end])->sum('total');
        $totalOrders = Order::whereBetween('orders.created_at', [$start, $end])->count();
        $totalProducts = Order::whereBetween('orders.created_at', [$start, $end])->sum('items_qty');
        $averageOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        // Top 5 productos más vendidos
        $topProducts = DB::table('order_details')
            ->join('orders', 'order_details.sale_order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select(
                'products.description as product_name',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('SUM(order_details.total) as total_sales')
            )
            ->groupBy('products.id', 'products.description')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Ventas por día (para gráfica)
        $salesByDay = Order::whereBetween('orders.created_at', [$start, $end])
            ->select(
                DB::raw('DATE(orders.created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Ventas por método de pago - CORREGIDO
        $salesByPaymentMethod = Order::whereBetween('orders.created_at', [$start, $end])
            ->join('payment_methods', 'orders.payment_method_id', '=', 'payment_methods.id')
            ->select(
                'payment_methods.description as method',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(orders.total) as total_amount')
            )
            ->groupBy('payment_methods.id', 'payment_methods.description')
            ->get();

        // Últimas 10 órdenes
        $recentOrders = Order::with(['paymentMethod', 'seller'])
            ->whereBetween('orders.created_at', [$start, $end])
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        // Top 5 vendedores
        $topSellers = Order::whereBetween('orders.created_at', [$start, $end])
            ->join('users', 'orders.seller_id', '=', 'users.id')
            ->select(
                'users.name',
                'users.lastname',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(orders.total) as total_sales')
            )
            ->groupBy('users.id', 'users.name', 'users.lastname')
            ->orderBy('total_sales', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'averageOrder',
            'topProducts',
            'salesByDay',
            'salesByPaymentMethod',
            'recentOrders',
            'topSellers',
            'startDate',
            'endDate'
        ));
    }
}