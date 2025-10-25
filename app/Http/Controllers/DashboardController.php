<?php

namespace App\Http\Controllers;

use App\Models\DailySale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->firstOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $totalSales = DailySale::whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->sum(DB::raw('product_price * items_qty'));

        $totalProducts = DailySale::whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->sum('items_qty');

        $salesByDay = DailySale::select(
                DB::raw('DATE(daily_sales.created_at) as date'),
                DB::raw('SUM(daily_sales.product_price * daily_sales.items_qty) as total_sales'),
                DB::raw('SUM(daily_sales.items_qty) as total_quantity')
            )
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(daily_sales.created_at)'))
            ->orderBy('date')
            ->get();

        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->endOfMonth();
        
        $actualSales = DailySale::select(
                DB::raw('DATE_FORMAT(daily_sales.created_at, "%Y-%m") as month'),
                DB::raw('SUM(daily_sales.product_price * daily_sales.items_qty) as total_sales'),
                DB::raw('SUM(daily_sales.items_qty) as total_quantity')
            )
            ->whereBetween('daily_sales.created_at', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->groupBy(DB::raw('DATE_FORMAT(daily_sales.created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get()
            ->keyBy('month');
        
        $salesByMonth = collect();
        $currentMonth = $start->copy();
        
        while ($currentMonth->format('Y-m') <= $end->format('Y-m')) {
            $monthKey = $currentMonth->format('Y-m');
            
            if (isset($actualSales[$monthKey])) {
                $salesByMonth->push([
                    'month' => $monthKey,
                    'total_sales' => (float) $actualSales[$monthKey]->total_sales,
                    'total_quantity' => (int) $actualSales[$monthKey]->total_quantity
                ]);
            } else {
                $salesByMonth->push([
                    'month' => $monthKey,
                    'total_sales' => 0,
                    'total_quantity' => 0
                ]);
            }
            
            $currentMonth->addMonth();
        }

        $topProducts = DailySale::select(
                'daily_sales.product_id',
                'products.description as product_name',
                DB::raw('SUM(daily_sales.items_qty) as total_quantity'),
                DB::raw('SUM(daily_sales.product_price * daily_sales.items_qty) as total_sales')
            )
            ->join('products', 'daily_sales.product_id', '=', 'products.id')
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy('daily_sales.product_id', 'products.description')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        $topSellers = DailySale::select(
                'daily_sales.seller_id',
                DB::raw('CONCAT(users.name, " ", users.lastname) as seller_name'),
                DB::raw('SUM(daily_sales.items_qty) as total_quantity'),
                DB::raw('SUM(daily_sales.product_price * daily_sales.items_qty) as total_sales')
            )
            ->join('users', 'daily_sales.seller_id', '=', 'users.id')
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy('daily_sales.seller_id', 'users.name', 'users.lastname')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        $recentSales = DailySale::with(['product', 'seller'])
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->orderBy('daily_sales.created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('dashboard.index', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalProducts',
            'salesByDay',
            'salesByMonth',
            'topProducts',
            'topSellers',
            'recentSales'
        ));
    }
}