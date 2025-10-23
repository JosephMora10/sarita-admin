@extends('layouts/contentNavbarLayout')

@section('title', 'Detalle de Orden')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Orden #{{ $order->id }}</h5>
        <a href="{{ route('orders') }}" class="btn btn-secondary btn-sm">
            <i class="mdi mdi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <p class="mb-2"><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-2"><strong>Vendedor:</strong> {{ $order->seller->name . ' ' . $order->seller->lastname }}</p>
                <p class="mb-2"><strong>Método de Pago:</strong> {{ $order->paymentMethod->description }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-2"><strong>Cantidad de Productos:</strong> {{ $order->items_qty }}</p>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-end">Precio</th>
                    <th class="text-end">Descuento</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($order->orderDetails as $orderDetail)
                <tr>
                    <td>
                        <span class="fw-medium">{{ $orderDetail->product->description }}</span>
                    </td>
                    <td class="text-center">{{ $orderDetail->quantity }}</td>
                    <td class="text-end">Q {{ number_format($orderDetail->price, 2) }}</td>
                    <td class="text-end">Q {{ number_format($orderDetail->discount, 2) }}</td>
                    <td class="text-end"><strong>Q {{ number_format($orderDetail->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                    <td class="text-end"><strong>Q {{ number_format($order->sub_total, 2) }}</strong></td>
                </tr>
                @if($order->discount > 0)
                <tr>
                    <td colspan="4" class="text-end"><strong>Descuento:</strong></td>
                    <td class="text-end text-danger"><strong>- Q {{ number_format($order->discount, 2) }}</strong></td>
                </tr>
                @endif
                <tr class="table-active">
                    <td colspan="4" class="text-end"><h5 class="mb-0">TOTAL:</h5></td>
                    <td class="text-end"><h5 class="mb-0">Q {{ number_format($order->total, 2) }}</h5></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="card-body">
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-info">
                <i class="mdi mdi-printer"></i> Imprimir
            </button>
        </div>
    </div>
</div>

@endsection