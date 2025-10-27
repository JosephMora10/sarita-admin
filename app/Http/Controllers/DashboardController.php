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

        $totalSales = DailySale::where('is_completed', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalProducts = DB::table('daily_sale_details')
            ->join('daily_sales', 'daily_sale_details.daily_sale_id', '=', 'daily_sales.id')
            ->where('daily_sales.is_completed', true)
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->sum('daily_sale_details.quantity');

        $salesByDay = DB::table('daily_sales')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->where('is_completed', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $quantitiesByDay = DB::table('daily_sale_details')
            ->select(
                DB::raw('DATE(daily_sales.created_at) as date'),
                DB::raw('SUM(daily_sale_details.quantity) as total_quantity')
            )
            ->join('daily_sales', 'daily_sale_details.daily_sale_id', '=', 'daily_sales.id')
            ->where('daily_sales.is_completed', true)
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(daily_sales.created_at)'))
            ->pluck('total_quantity', 'date');

        $salesByDay = $salesByDay->map(function($item) use ($quantitiesByDay) {
            $item->total_quantity = $quantitiesByDay->get($item->date, 0);
            return $item;
        });

        $start = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->endOfMonth();
        
        $actualSales = DB::table('daily_sales')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total_sales')
            )
            ->where('is_completed', true)
            ->whereBetween('created_at', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $quantitiesByMonth = DB::table('daily_sale_details')
            ->select(
                DB::raw('DATE_FORMAT(daily_sales.created_at, "%Y-%m") as month'),
                DB::raw('SUM(daily_sale_details.quantity) as total_quantity')
            )
            ->join('daily_sales', 'daily_sale_details.daily_sale_id', '=', 'daily_sales.id')
            ->where('daily_sales.is_completed', true)
            ->whereBetween('daily_sales.created_at', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->groupBy(DB::raw('DATE_FORMAT(daily_sales.created_at, "%Y-%m")'))
            ->pluck('total_quantity', 'month');

        $actualSales = $actualSales->map(function($item) use ($quantitiesByMonth) {
            $item->total_quantity = $quantitiesByMonth->get($item->month, 0);
            return $item;
        });
        
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

        $topProducts = DB::table('daily_sale_details')
            ->select(
                'products.id as product_id',
                'products.description as product_name',
                DB::raw('SUM(daily_sale_details.quantity) as total_quantity'),
                DB::raw('SUM(daily_sale_details.subtotal) as total_sales')
            )
            ->join('products', 'daily_sale_details.product_id', '=', 'products.id')
            ->join('daily_sales', 'daily_sale_details.daily_sale_id', '=', 'daily_sales.id')
            ->where('daily_sales.is_completed', true)
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.description')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        $topSellers = DB::table('daily_sales')
            ->select(
                'users.id as seller_id',
                'users.name',
                'users.lastname',
                DB::raw('CONCAT(users.name, " ", users.lastname) as seller_name'),
                DB::raw('SUM(daily_sales.total_amount) as total_sales')
            )
            ->join('users', 'daily_sales.seller_id', '=', 'users.id')
            ->where('daily_sales.is_completed', true)
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name', 'users.lastname')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        $quantitiesBySeller = DB::table('daily_sale_details')
            ->select(
                'daily_sales.seller_id',
                DB::raw('SUM(daily_sale_details.quantity) as total_quantity')
            )
            ->join('daily_sales', 'daily_sale_details.daily_sale_id', '=', 'daily_sales.id')
            ->where('daily_sales.is_completed', true)
            ->whereBetween('daily_sales.created_at', [$startDate, $endDate])
            ->groupBy('daily_sales.seller_id')
            ->pluck('total_quantity', 'seller_id');

        $topSellers = $topSellers->map(function($seller) use ($quantitiesBySeller) {
            $seller->total_quantity = $quantitiesBySeller->get($seller->seller_id, 0);
            return $seller;
        });

        $recentSales = DailySale::with(['details.product', 'seller'])
            ->where('is_completed', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
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