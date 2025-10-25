@extends('layouts/contentNavbarLayout')

@section('title', 'Productos')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Productos</h5>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCenter">
            <i class="ri-add-line me-1"></i>Agregar Producto
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($products as $product)
                    <tr class="text-center align-middle">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->description }}</td>
                        <td>Q{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category->description }}</td>
                        @if ($product->stock > 0)
                            <td><span class="badge rounded-pill bg-label-success me-1">Disponible</span></td>
                        @else
                            <td><span class="badge rounded-pill bg-label-danger me-1">Agotado</span></td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $product->id }}">
                                        <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                        Editar
                                    </button>
                                    <button type="button" class="dropdown-item text-danger">
                                        <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(method_exists($products, 'links'))
            <x-pagination :paginator="$products" />
        @endif
    </div>
</div>

<div class="modal fade" id="modalCenter" tabindex="-1" aria-labelledby="modalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="descriptionCreate" class="form-control" placeholder="Cono" name="description" required />
                                <label for="descriptionCreate">Nombre del Producto</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="number" id="priceCreate" class="form-control" placeholder="12.00" name="price" step="0.01" min="0" required />
                                <label for="priceCreate">Precio</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="number" id="stockCreate" class="form-control" placeholder="12" name="stock" min="0" required />
                            <label for="stockCreate">Stock</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="categoryCreate" class="form-label">Categoría</label>
                        <select class="form-select" name="category_id" id="categoryCreate" required>
                            <option value="" disabled selected>Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger" style="flex: 1;">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($products as $product)
<div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $product->id }}">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="descriptionEdit{{ $product->id }}" class="form-control" placeholder="Cono" name="description" value="{{ $product->description }}" required />
                                <label for="descriptionEdit{{ $product->id }}">Nombre del Producto</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="number" id="priceEdit{{ $product->id }}" class="form-control" placeholder="12.00" name="price" value="{{ $product->price }}" step="0.01" min="0" required />
                                <label for="priceEdit{{ $product->id }}">Precio</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="number" id="stockEdit{{ $product->id }}" class="form-control" placeholder="12" name="stock" value="{{ $product->stock }}" min="0" required />
                            <label for="stockEdit{{ $product->id }}">Stock</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="categoryEdit{{ $product->id }}" class="form-label">Categoría</label>
                        <select class="form-select" name="category_id" id="categoryEdit{{ $product->id }}" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $category->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="flex: 1;">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger" style="flex: 1;">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3 position-fixed top-0 end-0 m-3" role="alert" id="success-alert" style="z-index: 9999;">
        <strong>¡Éxito!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
    </script>
@endif

<style>
@media (max-width: 575.98px) {
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .modal-footer {
        padding: 0.75rem 1rem;
    }
    
    .form-floating > label {
        font-size: 0.875rem;
    }
    
    .card-header {
        padding: 1rem;
    }
}

.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
@media (max-width: 767.98px) {
    .btn {
        min-height: 44px;
    }
    
    .form-control,
    .form-select {
        min-height: 44px;
    }
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .table th,
    .table td {
        padding: 0.5rem;
    }
}
</style>

@endsection