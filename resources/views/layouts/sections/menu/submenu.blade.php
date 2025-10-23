@php
use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
    @if (isset($menu))
        @foreach ($menu as $submenu)
            @php
                $activeClass = '';
                if (isset($submenu->slug) && (Route::is($submenu->slug) || Route::is($submenu->slug . '.*'))) {
                    $activeClass = 'active open';
                }
            @endphp

            <li class="menu-item {{ $activeClass }}">
                <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                   class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                   @if (isset($submenu->target) && !empty($submenu->target)) target="_blank" @endif>
                    @isset($submenu->icon)
                        <i class="{{ $submenu->icon }}"></i>
                    @endisset
                    <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                    @isset($submenu->badge)
                        <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}</div>
                    @endisset
                </a>

                {{-- Submenús anidados --}}
                @if (isset($submenu->submenu))
                    @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                @endif
            </li>
        @endforeach
    @endif
</ul>
