@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-emerald-800 text-white py-16 px-4 text-center">
    <div class="max-w-4xl mx-auto space-y-3" data-aos="fade-down">
        <span class="text-xs uppercase font-bold tracking-widest text-amber-300 bg-white/10 px-3 py-1 rounded-full">
            Tentang Kami
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold font-playfair">Profil & Sejarah Organisasi</h1>
        <p class="text-emerald-100 text-sm sm:text-base max-w-2xl mx-auto">
            Mengenal lebih dekat kiprah dan struktur kepengurusan {{ $profile->nama_organisasi ?? 'Nahdlatul Ulama' }}
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-16 space-y-16">
    <!-- Sejarah & Tentang -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 space-y-6" data-aos="fade-up">
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-black text-gray-900 font-playfair flex items-center gap-3">
                <i class="fas fa-book-open text-emerald-700"></i>
                <span>Sejarah & Kilas Balik</span>
            </h2>
        </div>
        <div class="prose prose-emerald max-w-none text-gray-600 leading-relaxed text-sm sm:text-base space-y-4">
            {!! nl2br(e($profile->sejarah ?? 'Nahdlatul Ulama didirikan pada tanggal 16 Rajab 1344 H / 31 Januari 1926 M di Surabaya oleh para ulama pesantren di bawah kepemimpinan Hadratussyaikh KH. Hasyim Asy\'ari. Di tingkat ranting, kepengurusan hadir sebagai ujung tombak pelestarian amaliah Aswaja an-Nahdliyyah, pemberdayaan sosial, dan pengokoh persaudaraan antarwarga.')) !!}
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8" data-aos="fade-up">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-700 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fas fa-eye"></i>
            </div>
            <h3 class="text-xl font-black text-gray-900 font-playfair">Visi Organisasi</h3>
            <p class="text-gray-600 leading-relaxed text-sm">
                {{ $profile->visi ?? 'Menjadi pusat gerakan dakwah Islam Ahlussunnah wal Jama\'ah yang mandiri, maslahat, dan berdaya guna bagi kemaslahatan umat di tingkat ranting.' }}
            </p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fas fa-bullseye"></i>
            </div>
            <h3 class="text-xl font-black text-gray-900 font-playfair">Misi Organisasi</h3>
            <div class="text-gray-600 leading-relaxed text-sm space-y-2">
                {!! nl2br(e($profile->misi ?? "1. Menguatkan paham Ahlussunnah wal Jama'ah an-Nahdliyyah di tengah masyarakat.\n2. Mengoptimalkan pelayanan sosial, keagamaan, dan pendidikan keagamaan.\n3. Membangun kemandirian ekonomi umat melalui sinergi zakat, infaq, dan sedekah.\n4. Memperkokoh tali ukhuwah Islamiyyah, Wathaniyyah, dan Basyariyyah.")) !!}
            </div>
        </div>
    </section>

    <!-- Struktur Kepengurusan -->
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 space-y-8" data-aos="fade-up">
        <div class="text-center max-w-xl mx-auto space-y-2">
            <span class="text-emerald-700 font-extrabold text-xs tracking-wider uppercase bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                Amanah Khidmah
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 font-playfair">
                Struktur Kepengurusan
            </h2>
            <p class="text-gray-500 text-xs sm:text-sm">Periode Khidmah: {{ $profile->periode ?? '2024 - 2029' }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($pengurusRanting as $pengurus)
                <div class="bg-gray-50 rounded-2xl p-5 text-center border border-gray-100 card-hover">
                    <img src="{{ $pengurus->foto_url }}" alt="{{ $pengurus->nama_lengkap }}" class="w-20 h-20 mx-auto rounded-full object-cover border-2 border-emerald-700 mb-3 shadow">
                    <h4 class="font-bold text-gray-800 text-sm leading-snug">{{ $pengurus->nama_lengkap }}</h4>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full inline-block mt-1">
                        {{ $pengurus->jabatan }}
                    </span>
                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-gray-400">
                    <i class="fas fa-users text-2xl mb-2"></i>
                    <p>Susunan pengurus sedang dalam proses pembaruan.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection
