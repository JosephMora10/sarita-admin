@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Users')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Usuarios</h5>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCenter">
            <i class="ri-add-line me-1"></i>Agregar Usuario
        </button>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-center align-middle">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($users as $user)
                    <tr class="text-center align-middle">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }} {{ $user->lastname }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        @if ($user->role == true)
                            <td><span class="badge rounded-pill bg-label-success me-1">Admin</span></td>
                        @else
                            <td><span class="badge rounded-pill bg-label-danger me-1">Usuario</span></td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}">
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
        @if(method_exists($users, 'links'))
            <x-pagination :paginator="$users" />
        @endif
    </div>
</div>

<div class="modal fade" id="modalCenter" tabindex="-1" aria-labelledby="modalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nameWithTitle" class="form-control" placeholder="John" name="name" required />
                                <label for="nameWithTitle">Nombre</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="lastnameWithTitle" class="form-control" placeholder="Doe" name="lastname" required />
                                <label for="lastnameWithTitle">Apellido</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="emailWithTitle" class="form-control" placeholder="xxxx@xxx.xx" name="email" autocomplete="new-email" required />
                                <label for="emailWithTitle">Email</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="tel" id="phoneWithTitle" class="form-control" placeholder="12345678" maxlength="8" name="phone" required />
                                <label for="phoneWithTitle">Teléfono</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="passwordWithTitle" class="form-control" placeholder="********" name="password" autocomplete="new-password" required />
                            <label for="passwordWithTitle">Password</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="roleSelect" class="form-label">Rol</label>
                        <select class="form-select" name="role" id="roleSelect" required>
                            <option value="" disabled selected>Selecciona un rol</option>
                            <option value="1">Admin</option>
                            <option value="0">User</option>
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

@foreach ($users as $user)
<div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $user->id }}">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nameEdit{{ $user->id }}" class="form-control" placeholder="John" name="name" value="{{ $user->name }}" required />
                                <label for="nameEdit{{ $user->id }}">Nombre</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="lastnameEdit{{ $user->id }}" class="form-control" placeholder="Doe" name="lastname" value="{{ $user->lastname }}" required />
                                <label for="lastnameEdit{{ $user->id }}">Apellido</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="emailEdit{{ $user->id }}" class="form-control" placeholder="xxxx@xxx.xx" name="email" value="{{ $user->email }}" required />
                                <label for="emailEdit{{ $user->id }}">Email</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="tel" id="phoneEdit{{ $user->id }}" class="form-control" placeholder="12345678" maxlength="8" name="phone" value="{{ $user->phone }}" required />
                                <label for="phoneEdit{{ $user->id }}">Teléfono</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="passwordEdit{{ $user->id }}" class="form-control" placeholder="********" name="password" />
                            <label for="passwordEdit{{ $user->id }}">Password (dejar vacío para no cambiar)</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="roleEdit{{ $user->id }}" class="form-label">Rol</label>
                        <select class="form-select" name="role" id="roleEdit{{ $user->id }}" required>
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
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