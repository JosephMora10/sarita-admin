@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
            <!-- Login -->
            <div class="card p-sm-7 p-2">
                 <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a class="app-brand-link gap-3">
                        <span class="app-brand-logo demo">@include('_partials.macros')</span>
                        <span class="text-center text-danger font-bold fs-3">Sarita la Montañita</span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-1">
                    <p class="mb-5">Por favor, inicia sesión para continuar</p>

                    <form id="formAuthentication" class="mb-5" action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required />
                            <label for="email">Email</label>
                        </div>
                        <div class="mb-5">
                            <div class="form-password-toggle form-control-validation">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control" name="password" required />
                                        <label for="password">Password</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <button class="btn btn-danger d-grid w-100" type="submit">login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
