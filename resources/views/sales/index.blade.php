@extends('layouts/contentNavbarLayout')

@section('title', 'Ordenes')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Ordenes</h5>
        <a href="{{ route('sales.create') }}" class="btn btn-danger">Crear Venta</a>
    </div>
    
    @if($sales->isEmpty())
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="mdi mdi-package-variant mdi-48px text-muted"></i>
            </div>
            <h5 class="mb-2">No hay ventas registradas</h5>
        </div>
    @else
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-center align-middle">
                        <th>ID</th>
                        <th>Cantidad de Productos</th>
                        <th>Total</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($sales as $sale)
                        <tr class="text-center align-middle">
                            <td><strong>#{{ $sale->id }}</strong></td>
                            <td>{{ $sale->items_qty }}</td>
                            <td>Q{{ $sale->total_amount }}</td>
                            <td>{{ $sale->seller->name . ' ' . $sale->seller->last_name }}</td>
                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('sales.show', $sale->id) }}" class="dropdown-item">
                                            <i class="icon-base ri ri-eye-line icon-18px me-1"></i>
                                            Ver
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('¿Estás seguro de eliminar esta venta?')">
                                                <i class="icon-base ri ri-delete-bin-line icon-18px me-1"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if(method_exists($sales, 'links'))
                <x-pagination :paginator="$sales" />
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