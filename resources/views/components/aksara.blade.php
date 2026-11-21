@props(['src', 'alt' => ''])

{{-- Gambar aksara/logo monokrom diwarnai via CSS mask; warna diatur dengan class bg-* --}}
<span {{ $attributes->merge(['class' => 'mask-art inline-block']) }}
      style="-webkit-mask-image: url('{{ $src }}'); mask-image: url('{{ $src }}');"
      role="img" aria-label="{{ $alt }}">
    <img src="{{ $src }}" alt="" class="block h-auto w-full opacity-0" aria-hidden="true">
</span>
