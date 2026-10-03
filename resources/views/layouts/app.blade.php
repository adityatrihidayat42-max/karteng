<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'NU Ranting') }}</title>
    <meta name="description" content="{{ $description ?? 'Sistem Informasi Nahdlatul Ulama Ranting' }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name') }}">
    <meta property="og:description" content="{{ $description ?? '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS Animations -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --nu-green: #00704A;
            --nu-green-dark: #005538;
            --nu-green-light: #E8F5F0;
            --nu-gold: #C9A227;
            --nu-gold-light: #FBF3DC;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .bg-nu-green { background-color: var(--nu-green); }
        .bg-nu-green-dark { background-color: var(--nu-green-dark); }
        .bg-nu-green-light { background-color: var(--nu-green-light); }
        .bg-nu-gold { background-color: var(--nu-gold); }
        .text-nu-green { color: var(--nu-green); }
        .text-nu-gold { color: var(--nu-gold); }
        .border-nu-green { border-color: var(--nu-green); }
        .border-nu-gold { border-color: var(--nu-gold); }

        /* Animated gradient */
        .gradient-animate {
            background: linear-gradient(135deg, var(--nu-green-dark), var(--nu-green), #1a8a5a, var(--nu-green-dark));
            background-size: 300% 300%;
            animation: gradientShift 8s ease infinite;
        }
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Floating animation */
        .float-animation { animation: float 3s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Pulse green */
        .pulse-green {
            animation: pulseGreen 2s infinite;
        }
        @keyframes pulseGreen {
            0%, 100% { box-shadow: 0 0 0 0 rgba(0,112,74,0.4); }
            70% { box-shadow: 0 0 0 10px rgba(0,112,74,0); }
        }

        /* Card hover effect */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        /* Scroll indicator */
        .scroll-indicator {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(8px); }
        }

        /* Gold underline */
        .gold-underline::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--nu-gold);
            margin: 8px auto 0;
            border-radius: 2px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--nu-green); border-radius: 3px; }

        /* Nav blur */
        .nav-blur {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">

    <!-- Navbar -->
    @include('components.navbar')

    <!-- Flash Messages -->
    @if(session('success'))
        <div id="alert-success" class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-fade-in" data-aos="fade-left">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div id="alert-error" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-3">
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
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 60
        });

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

        // Mobile menu toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                const icon = menuBtn.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });
        }

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            if (nav) {
                if (window.scrollY > 50) {
                    nav.classList.add('shadow-lg', 'bg-white');
                    nav.classList.remove('bg-transparent');
                } else {
                    nav.classList.remove('shadow-lg', 'bg-white');
                    nav.classList.add('bg-transparent');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
