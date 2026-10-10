<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'NU Ranting') }}</title>
    <meta name="description" content="{{ $description ?? 'Sistem Informasi Nahdlatul Ulama Ranting' }}">
    <meta name="theme-color" content="#027f52">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <script>document.documentElement.classList.add('js');</script>

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS (dipakai halaman lain) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ================================================================
           NU DESIGN TOKENS  (mengikuti desain "Beranda NU Ranting Hijau Modern")
           ================================================================ */
        :root {
            --nu-green: #027f52;
            --nu-green-700: #016b45;
            --nu-green-dark: #055631;
            --nu-green-deep: #013c2a;
            --nu-green-light: #e8f7f1;
            --nu-mint: #c4f1df;
            --nu-gold: #fcd12b;
            --nu-gold-soft: #fbf3dc;
            --nu-bg: #f8fbfb;
            --nu-bg-mint: #effaf7;
            --nu-ink: #12261e;
            --nu-muted: #5b6b64;
            --nu-line: #e3ece8;
            --nu-nav-h: 72px;
        }
        html { scroll-behavior: smooth; }
        body { margin: 0; overflow-x: clip; font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: var(--nu-bg); color: var(--nu-ink); }
        .font-playfair { font-family: 'Playfair Display', Georgia, serif; }

        /* Utilitas warna lama tetap dipertahankan agar halaman lain tidak rusak */
        .bg-nu-green { background-color: var(--nu-green); }
        .bg-nu-green-dark { background-color: var(--nu-green-dark); }
        .bg-nu-green-light { background-color: var(--nu-green-light); }
        .bg-nu-gold { background-color: var(--nu-gold); }
        .text-nu-green { color: var(--nu-green); }
        .text-nu-gold { color: var(--nu-gold); }
        .border-nu-green { border-color: var(--nu-green); }
        .border-nu-gold { border-color: var(--nu-gold); }
        .gradient-animate { background: linear-gradient(135deg, var(--nu-green-dark), var(--nu-green), #1a8a5a, var(--nu-green-dark)); background-size: 300% 300%; animation: gradientShift 8s ease infinite; }
        @keyframes gradientShift { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .float-animation { animation: nuFloat 3s ease-in-out infinite; }
        @keyframes nuFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .card-hover { transition: transform .3s ease, box-shadow .3s ease; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,.12); }
        .gold-underline::after { content: ''; display: block; width: 60px; height: 3px; background: var(--nu-gold); margin: 8px auto 0; border-radius: 2px; }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #eef3f1; }
        ::-webkit-scrollbar-thumb { background: var(--nu-green); border-radius: 4px; }

        /* ================================================================
           NAVBAR
           ================================================================ */
        .nu-nav { position: fixed; inset: 0 0 auto 0; z-index: 60; height: var(--nu-nav-h); background: #fff; border-bottom: 1px solid transparent; transition: box-shadow .3s, border-color .3s; }
        .nu-nav.is-scrolled { box-shadow: 0 6px 24px rgba(1,60,42,.10); border-color: var(--nu-line); }
        .nu-nav-inner { max-width: 1200px; height: 100%; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .nu-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; flex-shrink: 0; }
        .nu-brand-logo { width: 42px; height: 42px; border-radius: 50%; background: var(--nu-green-dark); border: 2px solid var(--nu-gold); display: grid; place-items: center; color: var(--nu-gold); font-size: 17px; overflow: hidden; transition: transform .3s; }
        .nu-brand:hover .nu-brand-logo { transform: rotate(-8deg) scale(1.06); }
        .nu-brand-logo img { width: 100%; height: 100%; object-fit: cover; }
        .nu-brand-text { font-size: 11px; line-height: 1.25; font-weight: 800; letter-spacing: .04em; color: var(--nu-green); text-transform: uppercase; }
        .nu-links { display: none; align-items: center; gap: 2px; }
        .nu-links a { padding: 8px 13px; border-radius: 999px; font-size: 13px; font-weight: 500; color: #394a43; text-decoration: none; transition: background .2s, color .2s; line-height: 1.2; }
        .nu-links a:hover { background: var(--nu-green-light); color: var(--nu-green); }
        .nu-links a.active { background: var(--nu-green-light); color: var(--nu-green); font-weight: 700; }
        .nu-links a.two-line { text-align: left; font-size: 12px; max-width: 76px; padding: 4px 8px; }
        .nu-actions { display: none; align-items: center; gap: 14px; }
        .nu-btn-join { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 999px; background: var(--nu-green); color: #fff; font-size: 12px; font-weight: 700; line-height: 1.15; text-decoration: none; box-shadow: 0 6px 16px rgba(2,127,82,.28); transition: transform .2s, background .2s; }
        .nu-btn-join:hover { background: var(--nu-green-700); transform: translateY(-2px); }
        .nu-login { display: inline-flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; line-height: 1.15; color: #2c3c36; text-decoration: none; }
        .nu-login i { color: var(--nu-green); font-size: 14px; }
        .nu-login:hover { color: var(--nu-green); }
        .nu-burger { width: 42px; height: 42px; border: 0; border-radius: 12px; background: var(--nu-green-light); color: var(--nu-green); font-size: 18px; cursor: pointer; }
        .nu-mobile { display: none; position: absolute; top: var(--nu-nav-h); left: 0; right: 0; background: #fff; border-top: 1px solid var(--nu-line); box-shadow: 0 20px 40px rgba(1,60,42,.15); padding: 10px 16px 18px; max-height: calc(100svh - var(--nu-nav-h)); overflow-y: auto; }
        .nu-mobile.open { display: block; }
        .nu-mobile a { display: flex; align-items: center; gap: 12px; padding: 12px 12px; border-radius: 12px; color: #2c3c36; font-weight: 600; font-size: 15px; text-decoration: none; }
        .nu-mobile a i { width: 22px; text-align: center; color: var(--nu-green); }
        .nu-mobile a.active, .nu-mobile a:hover { background: var(--nu-green-light); color: var(--nu-green); }
        .nu-mobile .nu-mobile-cta { margin-top: 10px; display: grid; gap: 8px; }
        .nu-mobile .nu-mobile-cta .primary { background: var(--nu-green); color: #fff; justify-content: center; }
        .nu-mobile .nu-mobile-cta .primary i { color: #fff; }
        .nu-nav-spacer { height: var(--nu-nav-h); }
        main img, main table { max-width: 100%; }
        main table { display: block; overflow-x: auto; }
        @media (min-width: 1100px) { .nu-links { display: flex; } .nu-burger { display: none; } }
        @media (min-width: 900px) { .nu-actions { display: flex; } }

        /* Progress bar scroll */
        .nu-progress { position: fixed; top: var(--nu-nav-h); left: 0; height: 3px; width: 100%; z-index: 59; background: linear-gradient(90deg, var(--nu-gold), #fff2a8); transform-origin: 0 50%; transform: scaleX(0); pointer-events: none; }

        /* ================================================================
           FOOTER
           ================================================================ */
        .nu-footer { position: relative; overflow: hidden; background: var(--nu-green-deep); color: #cfe3da; padding: 56px 20px 0; }
        .nu-footer::before, .nu-footer::after { content: ''; position: absolute; width: 260px; height: 260px; border: 1px solid rgba(252,209,43,.18); border-radius: 50%; pointer-events: none; }
        .nu-footer::before { left: -90px; bottom: -90px; box-shadow: 0 0 0 28px rgba(252,209,43,.05), 0 0 0 56px rgba(252,209,43,.03); }
        .nu-footer::after { right: -90px; bottom: -90px; box-shadow: 0 0 0 28px rgba(252,209,43,.05), 0 0 0 56px rgba(252,209,43,.03); }
        .nu-footer-grid { position: relative; z-index: 2; max-width: 1200px; margin: 0 auto; display: grid; gap: 34px; grid-template-columns: 1fr; }
        @media (min-width: 700px) { .nu-footer-grid { grid-template-columns: 1fr 1fr; } }
        @media (min-width: 1000px) { .nu-footer-grid { grid-template-columns: 1.35fr 1fr 1.1fr 1.2fr; } }
        .nu-footer h4 { color: #fff; font-size: 13px; font-weight: 700; margin: 0 0 14px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,.14); }
        .nu-footer ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 9px; font-size: 12.5px; }
        .nu-footer ul a { color: #cfe3da; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: color .2s, transform .2s; }
        .nu-footer ul a:hover { color: var(--nu-gold); transform: translateX(3px); }
        .nu-footer ul a i { color: var(--nu-gold); font-size: 10px; }
        .nu-footer .contact li { display: flex; gap: 10px; align-items: flex-start; color: #e3f1ea; }
        .nu-footer .contact i { color: var(--nu-gold); width: 16px; margin-top: 3px; text-align: center; }
        .nu-footer-id { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .nu-footer-id .nu-brand-logo { width: 46px; height: 46px; }
        .nu-footer-id strong { color: #fff; font-size: 11.5px; letter-spacing: .04em; text-transform: uppercase; line-height: 1.3; display: block; }
        .nu-footer p.lead { font-size: 12px; line-height: 1.7; color: #b6d1c5; max-width: 300px; margin: 0 0 16px; }
        .nu-social { display: flex; gap: 10px; }
        .nu-social a { width: 34px; height: 34px; border-radius: 50%; border: 1px solid rgba(255,255,255,.35); color: #fff; display: grid; place-items: center; font-size: 13px; text-decoration: none; transition: background .2s, color .2s, transform .2s; }
        .nu-social a:hover { background: var(--nu-gold); color: var(--nu-green-deep); transform: translateY(-3px); }
        .nu-footer-bottom { position: relative; z-index: 2; max-width: 1200px; margin: 40px auto 0; padding: 18px 0 22px; border-top: 1px solid rgba(255,255,255,.14); display: flex; flex-wrap: wrap; gap: 8px; justify-content: space-between; font-size: 11px; color: #a9c6b8; }
        .nu-footer-bottom i { color: #fff; margin-left: 4px; }

        /* Tombol umum */
        .nu-btn { display: inline-flex; align-items: center; gap: 10px; padding: 13px 24px; border-radius: 999px; font-weight: 800; font-size: 13px; text-decoration: none; transition: transform .25s, box-shadow .25s, background .25s; }
        .nu-btn:hover { transform: translateY(-3px); }
        .nu-btn-gold { background: var(--nu-gold); color: var(--nu-green-deep); box-shadow: 0 10px 24px rgba(252,209,43,.28); }
        .nu-btn-gold:hover { box-shadow: 0 16px 32px rgba(252,209,43,.42); }
        .nu-btn-ghost { color: #fff; border: 1.5px solid rgba(255,255,255,.7); background: rgba(255,255,255,.06); backdrop-filter: blur(6px); }
        .nu-btn-ghost:hover { background: rgba(255,255,255,.18); }
        .nu-btn-text { color: #fff; font-weight: 700; padding: 13px 8px; }
        .nu-btn-text i { transition: transform .2s; }
        .nu-btn-text:hover i { transform: translateX(4px); }
    </style>
    @stack('styles')
</head>
<body class="antialiased">

    <!-- Navbar -->
    @include('components.navbar')

    <!-- Flash Messages -->
    @if(session('success'))
        <div id="alert-success" class="fixed top-20 right-4 z-[70] bg-green-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div id="alert-error" class="fixed top-20 right-4 z-[70] bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- AOS Init -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        if (window.AOS) {
            AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });
        }

        // Auto-dismiss alerts
        setTimeout(() => {
            ['alert-success', 'alert-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity 0.5s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                }
            });
        }, 4000);

        // Mobile menu
        (function () {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if (!btn || !menu) return;
            btn.addEventListener('click', () => {
                const open = menu.classList.toggle('open');
                btn.setAttribute('aria-expanded', open ? 'true' : 'false');
                const icon = btn.querySelector('i');
                icon.classList.toggle('fa-bars', !open);
                icon.classList.toggle('fa-xmark', open);
            });
        })();

        // Navbar shadow + progress bar saat scroll
        (function () {
            const nav = document.getElementById('main-nav');
            const bar = document.getElementById('nu-progress');
            function update() {
                const y = window.scrollY || document.documentElement.scrollTop;
                if (nav) nav.classList.toggle('is-scrolled', y > 10);
                if (bar) {
                    const max = document.documentElement.scrollHeight - window.innerHeight;
                    bar.style.transform = 'scaleX(' + (max > 0 ? Math.min(1, y / max) : 0) + ')';
                }
            }
            window.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
            update();
        })();
    </script>
    @stack('scripts')
</body>
</html>
