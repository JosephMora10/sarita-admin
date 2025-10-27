@extends('layouts/contentNavbarLayout')

@section('title', 'Orden')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Orden #{{ $sale->id }}</h5>
    </div>
    
    @if(!$sales)
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="mdi mdi-package-variant mdi-48px text-muted"></i>
            </div>
            <h5 class="mb-2">No se encontró la orden</h5>
        </div>
    @else
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-center align-middle">
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($sales as $sale)
                        <tr class="text-center align-middle">
                            <td>{{ $sale->daily_sale_id }}</td>
                            <td>{{ $sale->product->description }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>Q{{ $sale->unit_price }}</td>
                            <td>Q{{ $sale->subtotal }}</td>
                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
