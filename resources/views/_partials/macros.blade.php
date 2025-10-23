@php
  $width = $width ?? '80';
  $height = $height ?? '80';
@endphp

<span class="text-primary">
    <img width="{{ $width }}" height="{{ $height }}" fill="none" src="{{ asset('assets/json/imgs/download.svg') }}">
</span>
