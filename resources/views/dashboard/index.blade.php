@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const salesByDayData = @json($salesByDay);
        const salesByDayOptions = {
            chart: {
                type: 'line',
                height: 350,
                toolbar: { show: false }
            },
            series: [{
                name: 'Ventas',
                data: salesByDayData.map(item => item.total_sales)
            }],
            xaxis: {
                categories: salesByDayData.map(item => new Date(item.date).toLocaleDateString('es-ES', {day: '2-digit', month: 'short'}))
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Q' + value.toLocaleString('es-GT');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Q' + value.toLocaleString('es-GT', {minimumFractionDigits: 2});
                    }
                }
            }
        };
        const salesByDayChart = new ApexCharts(document.querySelector("#salesByDayChart"), salesByDayOptions);
        salesByDayChart.render();

        const salesByMonthData = @json($salesByMonth);
        const salesByMonthOptions = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Ventas',
                data: salesByMonthData.map(item => item.total_sales)
            }],
            xaxis: {
                categories: salesByMonthData.map(item => {
                    const [year, month] = item.month.split('-');
                    return new Date(year, month - 1).toLocaleDateString('es-ES', {month: 'long', year: 'numeric'});
                })
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Q' + value.toLocaleString('es-GT');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Q' + value.toLocaleString('es-GT', {minimumFractionDigits: 2});
                    }
                }
            }
        };
        const salesByMonthChart = new ApexCharts(document.querySelector("#salesByMonthChart"), salesByMonthOptions);
        salesByMonthChart.render();
    });
</script>
@endsection

@section('content')
<div class="row gy-6">
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

    <div class="col-lg-6 col-md-6">
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

    <div class="col-lg-6 col-md-6">
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

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Ventas Diarias</h5>
                <p class="text-muted mb-0">Del {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
            </div>
            <div class="card-body">
                <div id="salesByDayChart"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Ventas por Mes</h5>
                <p class="text-muted mb-0">Comparativo mensual</p>
            </div>
            <div class="card-body">
                <div id="salesByMonthChart"></div>
            </div>
        </div>
    </div>

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
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSellers as $seller)
                            <tr>
                                <td>{{ $seller->seller_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-label-success">{{ $seller->total_quantity }}</span>
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

    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Últimas Ventas</h5>
            </div>
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Productos</th>
                                <th>Vendedor</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Total</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                            <tr>
                                <td><strong>#{{ $sale->id }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->details->count() }} {{ Str::plural('producto', $sale->details->count()) }}</td>
                                <td>{{ $sale->seller->name }} {{ $sale->seller->lastname }}</td>
                                <td class="text-center">
                                    <span class="badge bg-label-primary">{{ $sale->details->sum('quantity') }}</span>
                                </td>
                                <td class="text-end fw-bold">Q {{ number_format($sale->total_amount, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="ri-eye-line"></i> Ver Orden
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
</div>
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const salesByDay = @json($salesByDay);
    
    const dates = salesByDay.map(item => item.date);
    const totals = salesByDay.map(item => parseFloat(item.total_sales));
    const quantities = salesByDay.map(item => parseInt(item.total_quantity));

    const dayChartOptions = {
        series: [{
            name: 'Total Ventas',
            data: totals
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: true
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded',
                dataLabels: {
                    position: 'top'
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return 'Q ' + val.toFixed(2);
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        labels: dates,
        xaxis: {
            type: 'datetime',
            labels: {
                format: 'dd/MM'
            }
        },
        yaxis: {
            title: {
                text: 'Ventas (Q)',
            },
            labels: {
                formatter: function(val) {
                    return 'Q ' + val.toFixed(2);
                }
            }
        },
        colors: ['#7367F0'],
        tooltip: {
            y: {
                formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                    return 'Q ' + val.toFixed(2) + ' (' + quantities[dataPointIndex] + ' productos)';
                }
            }
        }
    };

    const dayChart = new ApexCharts(document.querySelector("#salesByDayChart"), dayChartOptions);
    dayChart.render();

    const salesByMonth = @json($salesByMonth);
    
    const months = salesByMonth.map(item => item.month);
    const monthlyTotals = salesByMonth.map(item => parseFloat(item.total_sales));
    const monthlyQuantities = salesByMonth.map(item => parseInt(item.total_quantity));

    const monthChartOptions = {
        series: [{
            name: 'Ventas (Q)',
            type: 'column',
            data: monthlyTotals
        }, {
            name: 'Cantidad Vendida',
            type: 'line',
            data: monthlyQuantities
        }],
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
                show: true
            }
        },
        stroke: {
            width: [0, 4]
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [0, 1]
        },
        labels: months,
        xaxis: {
            type: 'category',
            labels: {
                formatter: function(val) {
                    if (!val) return '';
                    const parts = val.split('-');
                    const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                                      'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    return monthNames[parseInt(parts[1]) - 1] + ' ' + parts[0];
                }
            }
        },
        yaxis: [{
            title: {
                text: 'Ventas (Q)',
            },
            labels: {
                formatter: function(val) {
                    return 'Q ' + val.toFixed(2);
                }
            }
        }, {
            opposite: true,
            title: {
                text: 'Cantidad'
            }
        }],
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val) {
                    return val.toFixed(0);
                }
            }
        },
        colors: ['#7367F0', '#28C76F']
    };

    const monthChart = new ApexCharts(document.querySelector("#salesByMonthChart"), monthChartOptions);
    monthChart.render();
});
</script>
@endsection