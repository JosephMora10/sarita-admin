@php
use Illuminate\Support\Facades\Route;
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <!-- App Brand -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">@include('_partials.macros')</span>
            <span class="app-brand-text text-danger demo menu-text fw-semibold ms-2">Sarita la montañita</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            {{-- Encabezado de grupo --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header mt-7">
                    <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                </li>
            @else
                @php
                    $activeClass = '';

                    // Si la ruta actual coincide con el slug o sus hijos
                    if (isset($menu->slug) && (Route::is($menu->slug) || Route::is($menu->slug . '.*'))) {
                        $activeClass = 'active open';
                    }

                    // Revisa si algún submenú coincide
                    if (isset($menu->submenu)) {
                        foreach ($menu->submenu as $child) {
                            if (isset($child->slug) && (Route::is($child->slug) || Route::is($child->slug . '.*'))) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                       class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                       @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        @isset($menu->badge)
                            <div class="badge rounded-pill bg-{{ $menu->badge[0] }} ms-auto">{{ $menu->badge[1] }}</div>
                        @endisset
                    </a>

                    {{-- Submenús --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach
    </ul>
</aside>
