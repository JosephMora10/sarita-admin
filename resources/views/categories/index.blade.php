@extends('layouts/contentNavbarLayout')

@section('title', 'Categories - Categories')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Categorias</h5>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCenter">Agregar Categoria</button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($categories as $category)
                    <tr class="text-center align-middle">
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $category->id }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Editar</button>
                                    <button type="button" class="dropdown-item">
                                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                    Eliminar</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div class="col-lg-4 col-md-6">
                        <div class="mt-4">
                            <div class="modal fade" id="modalCenter{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Editar Categoria</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-4">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" id="nameWithTitle" class="form-control" placeholder="John" name="description" value="{{ $category->description }}" />
                                                            <label for="nameWithTitle">Nombre</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        @if(method_exists($categories, 'links'))
            <x-pagination :paginator="$categories" />
        @endif
        <div class="col-lg-4 col-md-6">
            <div class="mt-4">
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Agregar Categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="nameWithTitle" class="form-control" placeholder="John" name="description" required />
                                                <label for="nameWithTitle">Nombre</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
