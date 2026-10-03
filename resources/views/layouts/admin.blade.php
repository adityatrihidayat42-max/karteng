<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}Admin | {{ config('app.name') }}</title>

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --nu-green: #00704A;
            --nu-green-dark: #005538;
            --nu-green-light: #E8F5F0;
            --nu-gold: #C9A227;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; }
        .bg-nu-green { background-color: var(--nu-green); }
        .bg-nu-green-dark { background-color: var(--nu-green-dark); }
        .text-nu-green { color: var(--nu-green); }
        .text-nu-gold { color: var(--nu-gold); }
        .sidebar-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-item:hover, .sidebar-item.active {
            background-color: rgba(0,112,74,0.12);
            border-left-color: var(--nu-gold);
            color: var(--nu-green);
        }
        .sidebar-item.active { font-weight: 600; }
        #sidebar { transition: transform 0.3s ease; }
        .card-stat {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        /* Custom scrollbar sidebar */
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }
    </style>
    @stack('styles')
</head>
<body class="antialiased">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-nu-green-dark flex-shrink-0 overflow-y-auto flex flex-col" style="background: linear-gradient(180deg, #003d2b 0%, #005538 40%, #00704A 100%);">
        <!-- Logo -->
        <div class="p-5 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-nu-green font-bold text-sm">NU</span>
                </div>
                <div>
                    <div class="text-white font-bold text-sm leading-tight">{{ config('app.name') }}</div>
                    <div class="text-green-300 text-xs">Panel Admin</div>
                </div>
            </a>
        </div>

        <!-- Admin Info -->
        <div class="px-4 py-3 border-b border-white/10">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar_url }}" alt="" class="w-9 h-9 rounded-full border-2 border-yellow-400">
                <div>
                    <div class="text-white text-xs font-semibold truncate max-w-[130px]">{{ auth()->user()->name }}</div>
                    <div class="text-green-300 text-xs">{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-0.5">
            @php
                $navItems = [
                    ['icon' => 'fa-gauge', 'label' => 'Dashboard', 'route' => 'admin.dashboard'],
                    ['icon' => 'fa-users', 'label' => 'Anggota', 'route' => 'admin.members.index'],
                    ['icon' => 'fa-sitemap', 'label' => 'Banom', 'route' => 'admin.banoms.index'],
                    ['icon' => 'fa-newspaper', 'label' => 'Berita', 'route' => 'admin.posts.index'],
                    ['icon' => 'fa-tags', 'label' => 'Kategori', 'route' => 'admin.categories.index'],
                    ['icon' => 'fa-calendar-days', 'label' => 'Agenda', 'route' => 'admin.agendas.index'],
                    ['icon' => 'fa-images', 'label' => 'Galeri', 'route' => 'admin.galleries.index'],
                    ['icon' => 'fa-hand-holding-heart', 'label' => 'Donasi/Infaq', 'route' => 'admin.donations.index'],
                    ['icon' => 'fa-id-card', 'label' => 'Cetak KTA', 'route' => 'admin.kta.index'],
                    ['icon' => 'fa-building', 'label' => 'Profil Organisasi', 'route' => 'admin.organization.edit'],
                    ['icon' => 'fa-user-shield', 'label' => 'User/Pengurus', 'route' => 'admin.users.index'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-green-100 text-sm {{ request()->routeIs($item['route']) || request()->routeIs(str_replace('.index','.*',$item['route'])) ? 'active' : '' }}">
                    <i class="fas {{ $item['icon'] }} w-4 text-center opacity-80"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Logout -->
        <div class="p-3 border-t border-white/10">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-green-200 text-sm hover:text-white transition mb-1">
                <i class="fas fa-globe w-4 text-center"></i>
                <span>Lihat Website</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-red-300 hover:text-red-200 hover:bg-red-900/20 text-sm transition">
                    <i class="fas fa-arrow-right-from-bracket w-4 text-center"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="text-gray-500 hover:text-nu-green lg:hidden">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <div>
                    <h1 class="text-gray-800 font-semibold text-base">@yield('page-title', 'Dashboard')</h1>
                    @if(isset($breadcrumbs))
                    <nav class="text-xs text-gray-400">
                        @foreach($breadcrumbs as $bc)
                            @if(!$loop->last)
                                <a href="{{ $bc['url'] ?? '#' }}" class="hover:text-nu-green">{{ $bc['label'] }}</a>
                                <span class="mx-1">/</span>
                            @else
                                <span>{{ $bc['label'] }}</span>
                            @endif
                        @endforeach
                    </nav>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-500">
                <i class="fas fa-clock"></i>
                <span id="live-time"></span>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-6 pt-4 space-y-2">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-3" x-data x-init="setTimeout(() => $el.remove(), 4000)">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto px-6 py-4">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Live clock
    function updateTime() {
        const el = document.getElementById('live-time');
        if (el) {
            const now = new Date();
            el.textContent = now.toLocaleString('id-ID', {
                weekday: 'short', day: 'numeric', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }
    }
    updateTime();
    setInterval(updateTime, 1000);

    // Sidebar toggle mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Confirm delete
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm(btn.dataset.confirm || 'Yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>
