{{--
    Bagan Struktur Badan Otonom (Banom) — tampilan bagan organisasi
    Pemakaian:  @include('components.banom-chart', ['banoms' => $banoms, 'detail' => false])
    $detail = true  -> tampilkan jumlah kader + tombol "Lihat Banom" (halaman direktori)
--}}
@once
@push('styles')
<style>
    .oc { --oc-orange: #f7941d; --oc-orange-2: #fbb03b; --oc-line: #1d3b4a; --oc-ring: 92px; --oc-plate: 164px; position: relative; padding: 8px 0 40px; isolation: isolate; }
    .oc *, .oc *::before, .oc *::after { box-sizing: border-box; }
    /* Latar menyatu dengan halaman: masjid samar yang memudar di semua sisi */
    .oc::before { content: ''; position: absolute; inset: -10px -4vw 0; z-index: -1; opacity: .16; pointer-events: none;
        background: url("{{ asset('images/nu/hero-mosque.jpg') }}") center bottom / cover no-repeat; filter: grayscale(.35);
        -webkit-mask-image: radial-gradient(ellipse 70% 75% at 50% 55%, #000 30%, transparent 100%); mask-image: radial-gradient(ellipse 70% 75% at 50% 55%, #000 30%, transparent 100%); }

    /* Pita judul */
    .oc-title-wrap { display: flex; justify-content: center; margin: 0 0 34px; }
    .oc-title { margin: 0; padding: 13px 54px 15px; font-size: clamp(13px, 2.6vw, 20px); font-weight: 800; letter-spacing: .04em; text-transform: uppercase; text-align: center; color: #fff;
        background: linear-gradient(180deg, var(--oc-orange-2), var(--oc-orange)); box-shadow: 0 8px 18px rgba(247,148,29,.35);
        clip-path: polygon(0 0, 100% 0, calc(100% - 16px) 50%, 100% 100%, 0 100%, 16px 50%); text-shadow: 0 1px 2px rgba(0,0,0,.25); }

    .oc-node { position: relative; display: flex; flex-direction: column; align-items: center; text-align: center; text-decoration: none; color: inherit; width: 100%; }
    .oc-tab { position: relative; z-index: 2; padding: 5px 14px; border-radius: 3px; font-size: 11.5px; font-weight: 800; letter-spacing: .02em; color: #fff; background: linear-gradient(180deg, var(--oc-orange-2), var(--oc-orange)); box-shadow: 0 3px 8px rgba(0,0,0,.15); max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .oc-ring { position: relative; z-index: 2; width: var(--oc-ring); height: var(--oc-ring); border-radius: 50%; margin: 12px 0 -14px; padding: 5px; box-shadow: 0 8px 18px rgba(2,60,40,.22);
        background: conic-gradient(from 200deg, var(--oc-orange) 0 50%, #1d4f91 50% 100%); transition: transform .3s; flex-shrink: 0; }
    .oc-ring > span { width: 100%; height: 100%; border-radius: 50%; border: 3px solid #fff; display: grid; place-items: center; overflow: hidden; color: var(--nu-green); font-size: calc(var(--oc-ring) * .37);
        background: radial-gradient(circle at 50% 30%, #fff 0%, var(--nu-green-light) 100%); }
    .oc-ring img { width: 78%; height: 78%; object-fit: contain; display: block; }
    a.oc-node:hover .oc-ring { transform: translateY(-4px) scale(1.04); }

    .oc-plate { position: relative; z-index: 1; width: 100%; max-width: var(--oc-plate); padding-top: 14px; border-radius: 4px; overflow: hidden; box-shadow: 0 8px 18px rgba(2,60,40,.18); background: var(--nu-green-dark); }
    .oc-plate .role { display: block; padding: 3px 6px; font-size: 10.5px; font-weight: 800; color: #fff; background: linear-gradient(180deg, var(--oc-orange-2), var(--oc-orange)); }
    .oc-plate .who { display: flex; flex-direction: column; justify-content: center; gap: 2px; min-height: 52px; padding: 8px 8px 9px; font-size: 11.5px; font-weight: 700; line-height: 1.25; color: #fff; overflow-wrap: anywhere;
        background: linear-gradient(180deg, #0a7a4d, var(--nu-green-dark)); }
    .oc-plate .who small { font-size: 9.5px; font-weight: 600; color: var(--nu-mint); }
    .oc-go { position: relative; z-index: 2; margin-top: 8px; padding: 1px 8px; border-radius: 6px; background: var(--nu-bg, #f8fbfb); font-size: 10.5px; font-weight: 800; color: var(--nu-green-dark); }
    .oc-go { white-space: nowrap; }
    .oc-dense .oc-l, .oc-compact .oc-l { display: none; }
    .oc-go i { font-size: 9px; transition: transform .2s; } a.oc-node:hover .oc-go i { transform: translateX(4px); }

    .oc-root { display: flex; flex-direction: column; align-items: center; position: relative; }
    .oc-root .oc-ring { --oc-ring: 104px; }
    .oc-root .oc-ring > span { background: var(--nu-green-dark); color: var(--nu-gold); font-size: 40px; }
    .oc-root .oc-plate { max-width: 210px; }
    .oc-root::after { content: ''; width: 2px; height: 28px; background: var(--oc-line); }

    .oc-children { list-style: none; margin: 0; padding: 0; display: flex; justify-content: center; position: relative; }
    .oc-children > li { position: relative; padding: 28px 6px 0; flex: 1 1 0; min-width: 0; max-width: 200px; display: flex; justify-content: center; }
    .oc-children > li::before, .oc-children > li::after { content: ''; position: absolute; top: 0; width: 50%; height: 28px; border-top: 2px solid var(--oc-line); }
    .oc-children > li::before { left: 0; }
    .oc-children > li::after { right: 0; border-left: 2px solid var(--oc-line); }
    .oc-children > li:first-child::before, .oc-children > li:last-child::after, .oc-children > li:only-child::before { border-top-color: transparent; }

    /* Banom banyak (7-8): sedikit lebih kecil agar muat satu baris */
    .oc-compact { --oc-ring: 78px; --oc-plate: 140px; }
    .oc-compact .oc-tab { font-size: 10.5px; padding: 4px 10px; }
    .oc-compact .oc-plate .who { font-size: 10.5px; min-height: 48px; padding: 7px 6px 8px; }
    .oc-compact .oc-go { font-size: 9.5px; }
    /* 9-10 banom */
    .oc-dense { --oc-ring: 64px; --oc-plate: 112px; }
    .oc-dense .oc-tab { font-size: 9.5px; padding: 3px 8px; }
    .oc-dense .oc-plate .role { font-size: 9px; }
    .oc-dense .oc-plate .who { font-size: 9.5px; min-height: 44px; padding: 6px 4px 7px; }
    .oc-dense .oc-plate .who small { font-size: 8.5px; }
    .oc-dense .oc-go { font-size: 9px; padding: 1px 4px; }
    .oc-dense .oc-children > li { padding-left: 3px; padding-right: 3px; }

    /* HP / tablet, atau lebih dari 10 banom: tersusun ke bawah dengan satu garis tengah */
    @media (max-width: 979px) {
        .oc .oc-children { flex-direction: column; align-items: center; padding-bottom: 4px; }
        .oc .oc-children::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 70px; width: 2px; margin-left: -1px; background: var(--oc-line); }
        .oc .oc-children > li { flex: none; width: 100%; max-width: 240px; padding: 26px 0 0; }
        .oc .oc-children > li::before, .oc .oc-children > li::after { display: none; }
        .oc .oc-root::after { height: 4px; }
        .oc { --oc-ring: 92px; --oc-plate: 164px; }
        .oc .oc-tab { font-size: 11.5px; padding: 5px 14px; }
        .oc .oc-plate .who { font-size: 11.5px; min-height: 52px; padding: 8px 8px 9px; }
        .oc .oc-plate .role { font-size: 10.5px; }
        .oc .oc-go { font-size: 10.5px; padding: 1px 8px; }
    }
    .oc-stack .oc-children { flex-direction: column; align-items: center; padding-bottom: 4px; }
    .oc-stack .oc-children::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 70px; width: 2px; margin-left: -1px; background: var(--oc-line); }
    .oc-stack .oc-children > li { flex: none; width: 100%; max-width: 240px; padding: 26px 0 0; }
    .oc-stack .oc-children > li::before, .oc-stack .oc-children > li::after { display: none; }
    .oc-stack .oc-root::after { height: 4px; }
</style>
@endpush
@endonce

@php
    $detail = $detail ?? false;
    // Enam Banom NU bawaan: selalu tampil di bagan, tanpa perlu diketik satu per satu.
    // Bila banom yang sama (singkatan sama) sudah ada di database, datanya (ketua, logo, link) dipakai.
    $defaults = [
        ['singkatan' => 'Muslimat NU', 'nama' => 'Muslimat Nahdlatul Ulama'],
        ['singkatan' => 'Fatayat NU',  'nama' => 'Fatayat Nahdlatul Ulama'],
        ['singkatan' => 'GP Ansor',    'nama' => 'Gerakan Pemuda Ansor'],
        ['singkatan' => 'Banser',      'nama' => 'Barisan Ansor Serbaguna'],
        ['singkatan' => 'IPNU',        'nama' => 'Ikatan Pelajar Nahdlatul Ulama'],
        ['singkatan' => 'IPPNU',       'nama' => 'Ikatan Pelajar Putri Nahdlatul Ulama'],
    ];
    $norm = fn ($v) => preg_replace('/[^a-z0-9]/', '', strtolower((string) $v));
    $dbList = collect($banoms ?? []);
    $used = [];
    $items = [];
    foreach ($defaults as $d) {
        $m = $dbList->first(fn ($b) => $norm($b->singkatan) === $norm($d['singkatan']) || $norm($b->nama) === $norm($d['nama']));
        if ($m) { $used[] = $m->id ?? spl_object_id($m); }
        $items[] = [
            'singkatan' => $m->singkatan ?? $d['singkatan'],
            'nama'      => $m->nama ?? $d['nama'],
            'ketua'     => $m->ketua ?? null,
            'logo'      => $m->logo ?? null,
            'count'     => $m->members_count ?? 0,
            'url'       => $m ? route('banom.show', $m->slug) : null,
        ];
    }
    foreach ($dbList as $b) {
        if (in_array($b->id ?? spl_object_id($b), $used, true)) continue;
        $items[] = ['singkatan' => $b->singkatan ?? 'BANOM', 'nama' => $b->nama, 'ketua' => $b->ketua, 'logo' => $b->logo, 'count' => $b->members_count ?? 0, 'url' => route('banom.show', $b->slug)];
    }
@endphp
@php $oc_n = count($items); $oc_cls = $oc_n <= 6 ? '' : ($oc_n <= 8 ? 'oc-compact' : ($oc_n <= 10 ? 'oc-dense' : 'oc-stack')); @endphp
<div class="oc {{ $oc_cls }}" data-scrub>
    <div class="oc-title-wrap"><h3 class="oc-title">Struktur Badan Otonom NU Ranting Karangtengah</h3></div>

    <div class="oc-root">
        <span class="oc-tab">NU Ranting Karangtengah</span>
        <div class="oc-ring"><span><i class="fas fa-mosque"></i></span></div>
        <div class="oc-plate">
            <span class="role">Pengurus</span>
            <div class="who">Nahdlatul Ulama<small>Pimpinan Ranting Karangtengah</small></div>
        </div>
    </div>

    <ul class="oc-children">
        @foreach($items as $it)
            <li>
                <{!! $it['url'] ? 'a href="'.e($it['url']).'"' : 'div' !!} class="oc-node" title="{{ $it['nama'] }}">
                    <span class="oc-tab">{{ $it['singkatan'] }}</span>
                    <div class="oc-ring">
                        <span>@if($it['logo'])<img src="{{ asset('storage/' . $it['logo']) }}" alt="{{ $it['nama'] }}">@else<i class="fas fa-users-gear"></i>@endif</span>
                    </div>
                    <div class="oc-plate">
                        <span class="role">Ketua</span>
                        <div class="who">
                            {{ $it['ketua'] ?: $it['nama'] }}
                            @if($it['ketua'])<small>{{ $it['nama'] }}</small>@endif
                        </div>
                    </div>
                    @if($it['url'])
                        <span class="oc-go">@if($detail)<span class="oc-k">{{ $it['count'] }} Kader</span><span class="oc-l"> &middot; Lihat Banom</span>@else Detail @endif <i class="fas fa-arrow-right"></i></span>
                    @endif
                </{!! $it['url'] ? 'a' : 'div' !!}>
            </li>
        @endforeach
    </ul>
</div>
