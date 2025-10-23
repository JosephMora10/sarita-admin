@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Ventas')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('content')
<div class="row gy-6">
    <!-- Filtros de Fecha -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $startDate }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $endDate }}" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="menu-icon icon-base ri ri-filter-2-fill"></i>Filtrar
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="menu-icon icon-base ri ri-refresh-line"></i>Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Estadísticas Principales -->
    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-primary rounded">
                            <i class="ri ri-money-dollar-circle-fill h-75 w-75"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Ventas Totales</p>
                        <h4 class="mb-0">Q {{ number_format($totalSales, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-success rounded shadow-xs">
                            <i class="ri ri-list-ordered-2 h-75 w-75"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Órdenes</p>
                        <h4 class="mb-0">{{ number_format($totalOrders) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-warning rounded shadow-xs">
                            <i class="ri ri-box-1-fill h-75 w-75"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Productos Vendidos</p>
                        <h4 class="mb-0">{{ number_format($totalProducts) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar">
                        <div class="avatar-initial bg-info rounded shadow-xs">
                            <i class="ri ri-arrow-left-right-line h-75 w-75"></i>
                        </div>
                    </div>
                    <div class="ms-3">
                        <p class="mb-0">Promedio por Orden</p>
                        <h4 class="mb-0">Q {{ number_format($averageOrder, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica de Ventas por Día -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Ventas Diarias</h5>
                <p class="text-muted mb-0">Del {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
            </div>
            <div class="card-body">
                <div id="salesChart"></div>
            </div>
        </div>
    </div>

    <!-- Ventas por Método de Pago -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Métodos de Pago</h5>
            </div>
            <div class="card-body">
                @foreach($salesByPaymentMethod as $method)
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-0">{{ $method->method }}</h6>
                        <small class="text-muted">{{ $method->total_orders }} órdenes</small>
                    </div>
                    <h6 class="mb-0 text-success">Q {{ number_format($method->total_amount, 2) }}</h6>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top Productos -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Productos Más Vendidos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Ventas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-label-danger">{{ $product->total_quantity }}</span>
                                </td>
                                <td class="text-end">Q {{ number_format($product->total_sales, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Vendedores -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Top Vendedores</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Vendedor</th>
                                <th class="text-center">Órdenes</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSellers as $seller)
                            <tr>
                                <td>{{ $seller->name }} {{ $seller->last_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-label-success">{{ $seller->total_orders }}</span>
                                </td>
                                <td class="text-end">Q {{ number_format($seller->total_sales, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Órdenes -->
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Últimas Órdenes</h5>
                <a href="{{ route('orders') }}" class="btn btn-sm btn-danger">Ver Todas</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Vendedor</th>
                            <th>Método de Pago</th>
                            <th class="text-center">Items</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->seller->name }} {{ $order->seller->last_name }}</td>
                            <td>{{ $order->paymentMethod->description }}</td>
                            <td class="text-center">{{ $order->items_qty }}</td>
                            <td class="text-end"><strong>Q {{ number_format($order->total, 2) }}</strong></td>
                            <td class="text-center">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-icon btn-text-secondary">
                                    <i class="ri ri-eye-line h-75 w-75"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos para la gráfica
    const salesData = @json($salesByDay);
    
    const dates = salesData.map(item => item.date);
    const totals = salesData.map(item => parseFloat(item.total));
    const orders = salesData.map(item => parseInt(item.orders_count));

    // Configuración de la gráfica
    const options = {
        series: [{
            name: 'Ventas (Q)',
            type: 'column',
            data: totals
        }, {
            name: 'Órdenes',
            type: 'line',
            data: orders
        }],
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
                show: false
            }
        },
        stroke: {
            width: [0, 4]
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1]
        },
        labels: dates,
        xaxis: {
            type: 'datetime',
            labels: {
                format: 'dd/MM'
            }
        },
        yaxis: [{
            title: {
                text: 'Ventas (Q)',
            },
        }, {
            opposite: true,
            title: {
                text: 'Órdenes'
            }
        }],
        colors: ['#7367F0', '#28C76F']
    };

    const chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
});
</script>
@endsection