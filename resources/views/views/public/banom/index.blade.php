@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Sayap Pergerakan
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Direktori Badan Otonom (BANOM)</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-xl mx-auto">
            Wadah perjuangan dan kaderisasi warga nahdliyin berbasis usia, profesi, dan kelompok kemasyarakatan.
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
    @include('components.banom-chart', ['banoms' => $banoms, 'detail' => true])
</div>
@endsection
