@extends('layouts/contentNavbarLayout')

@section('title', 'Users - Users')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Usuarios</h5>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCenter">Agregar Usuario</button>
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
                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCenter{{ $user->id }}">
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
                            <div class="modal fade" id="modalCenter{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalCenterTitle">Editar Usuario</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-4">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" id="nameWithTitle" class="form-control" placeholder="John" name="name" value="{{ $user->name }}" />
                                                            <label for="nameWithTitle">Nombre</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" id="lastnameWithTitle" class="form-control" placeholder="Doe" name="lastname" value="{{ $user->lastname }}" />
                                                            <label for="lastnameWithTitle">Apellido</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="email" id="emailWithTitle" class="form-control" placeholder="xxxx@xxx.xx" name="email" value="{{ $user->email }}" />
                                                            <label for="emailWithTitle">Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" id="phoneWithTitle" class="form-control" placeholder="123456789" name="phone" maxlength="8" value="{{ $user->phone }}" />
                                                            <label for="phoneWithTitle">Telefono</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col mb-2">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="password" id="passwordWithTitle" class="form-control" name="password" />
                                                            <label for="passwordWithTitle">Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn-group">
                                                    <select class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" name="role" id="roleSelect">
                                                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
                                                    </select>
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
        @if(method_exists($users, 'links'))
            <x-pagination :paginator="$users" />
        @endif
        <div class="col-lg-4 col-md-6">
            <div class="mt-4">
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Agregar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="nameWithTitle" class="form-control" placeholder="John" name="name" required />
                                                <label for="nameWithTitle">Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="lastnameWithTitle" class="form-control" placeholder="Doe" name="lastname" required />
                                                <label for="lastnameWithTitle">Apellido</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="email" id="emailWithTitle" class="form-control" placeholder="xxxx@xxx.xx" name="email" autocomplete="new-email" required />
                                                <label for="emailWithTitle">Email</label>
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="phoneWithTitle" class="form-control" placeholder="123456789" maxlength="8" name="phone" required />
                                                <label for="phoneWithTitle">Telefono</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col mb-2">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="passwordWithTitle" class="form-control" placeholder="********" name="password" autocomplete="new-password" required />
                                                <label for="passwordWithTitle">Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <select class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" name="role" id="">
                                            <option value="1">Admin</option>
                                            <option value="0">User</option>
                                        </select>
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
