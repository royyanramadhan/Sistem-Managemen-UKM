{{-- Logo Portal UKM — usage: @include('partials._logo', ['class' => 'h-20']) --}}
@php $logoClass = $class ?? 'h-10'; @endphp
<a href="{{ $href ?? route('landing') }}" class="inline-flex items-center shrink-0 {{ $linkClass ?? '' }}">
    <img src="{{ asset('images/logo-portal-ukm.png') }}" alt="Portal UKM Universitas Malikussaleh" class="{{ $logoClass }} w-auto object-contain">
</a>
