@extends('layouts/contentNavbarLayout')

@section('title', 'Orders - Orders')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Ordenes</h5>
        <a href="{{ route('orders.create') }}" class="btn btn-danger">Crear Orden</a>
    </div>
    
    @if($orders->isEmpty())
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="mdi mdi-package-variant mdi-48px text-muted"></i>
            </div>
            <h5 class="mb-2">No hay órdenes registradas</h5>
        </div>
    @else
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-center align-middle">
                        <th>ID</th>
                        <th>Cantidad de Productos</th>
                        <th>Subtotal</th>
                        <th>Descuento</th>
                        <th>Total</th>
                        <th>Metodo de Pago</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($orders as $order)
                        <tr class="text-center align-middle">
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->items_qty }}</td>
                            <td>Q {{ number_format($order->sub_total, 2) }}</td>
                            <td>Q {{ number_format($order->discount, 2) }}</td>
                            <td><strong>Q {{ number_format($order->total, 2) }}</strong></td>
                            <td>{{ $order->paymentMethod->description }}</td>
                            <td>{{ $order->seller->name . ' ' . $order->seller->last_name }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('orders.show', $order->id) }}" class="dropdown-item">
                                            <i class="icon-base ri ri-eye-line icon-18px me-1"></i>
                                            Ver
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if(method_exists($orders, 'links'))
                <x-pagination :paginator="$orders" />
            @endif
        </div>
    @endif
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="success-alert">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
@endif

@endsection