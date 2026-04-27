<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Masjid Al-Hasanah</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        sidebar: {
                            bg: '#1e293b',
                            hover: '#334155',
                            active: '#22c55e',
                            text: '#e2e8f0',
                            textMuted: '#94a3b8',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
        
        /* Sidebar transitions */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Content animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar-bg shadow-xl transform lg:translate-x-0 lg:static lg:inset-0 sidebar-transition"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between h-16 px-6 border-b border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mosque text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-lg">Admin Panel</h1>
                            <p class="text-sidebar-textMuted text-xs">Masjid Al-Hasanah</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-sidebar-textMuted hover:text-white">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Sidebar Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-sidebar-active text-white' : '' }}">
                        <i class="fas fa-dashboard w-5 text-center"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <!-- Galeri Management -->
                    <div x-data="{ open: @json(request()->routeIs('admin.galeri*')) }" class="space-y-1">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-images w-5 text-center"></i>
                                <span class="font-medium">Galeri</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse class="ml-8 space-y-1">
                            <a href="{{ route('admin.galeri.index') }}" 
                               class="block px-4 py-2 text-sm text-sidebar-textMuted hover:text-white hover:bg-sidebar-hover rounded transition-colors {{ request()->routeIs('admin.galeri.index') ? 'text-white bg-sidebar-hover' : '' }}">
                                <i class="fas fa-list w-4 mr-2"></i>
                                Daftar Galeri
                            </a>
                            <a href="{{ route('admin.galeri.create') }}" 
                               class="block px-4 py-2 text-sm text-sidebar-textMuted hover:text-white hover:bg-sidebar-hover rounded transition-colors {{ request()->routeIs('admin.galeri.create') ? 'text-white bg-sidebar-hover' : '' }}">
                                <i class="fas fa-plus w-4 mr-2"></i>
                                Tambah Galeri
                            </a>
                        </div>
                    </div>
                    
                    <!-- DKM Management -->
                    <div x-data="{ open: @json(request()->routeIs('admin.dkm*')) }" class="space-y-1">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span class="font-medium">Struktur DKM</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse class="ml-8 space-y-1">
                            <a href="{{ route('admin.dkm.index') }}" 
                               class="block px-4 py-2 text-sm text-sidebar-textMuted hover:text-white hover:bg-sidebar-hover rounded transition-colors {{ request()->routeIs('admin.dkm.index') ? 'text-white bg-sidebar-hover' : '' }}">
                                <i class="fas fa-list w-4 mr-2"></i>
                                Daftar Anggota
                            </a>
                            <a href="{{ route('admin.dkm.create') }}" 
                               class="block px-4 py-2 text-sm text-sidebar-textMuted hover:text-white hover:bg-sidebar-hover rounded transition-colors {{ request()->routeIs('admin.dkm.create') ? 'text-white bg-sidebar-hover' : '' }}">
                                <i class="fas fa-plus w-4 mr-2"></i>
                                Tambah Anggota
                            </a>
                        </div>
                    </div>
                    
                    <!-- Kajian Management -->
                    <div x-data="{ open: @json(request()->routeIs('admin.kajian*')) }" class="space-y-1">
                        <button @click="open = !open" 
                                class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-calendar-alt w-5 text-center"></i>
                                <span class="font-medium">Jadwal Kajian</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="open" x-collapse class="ml-8 space-y-1">
                            <a href="{{ route('admin.kajian.index') }}" 
                               class="block px-4 py-2 text-sm text-sidebar-textMuted hover:text-white hover:bg-sidebar-hover rounded transition-colors {{ request()->routeIs('admin.kajian.index') ? 'text-white bg-sidebar-hover' : '' }}">
                                <i class="fas fa-list w-4 mr-2"></i>
                                Daftar Kajian
                            </a>
                            <a href="{{ route('admin.kajian.create') }}" 
                               class="block px-4 py-2 text-sm text-sidebar-textMuted hover:text-white hover:bg-sidebar-hover rounded transition-colors {{ request()->routeIs('admin.kajian.create') ? 'text-white bg-sidebar-hover' : '' }}">
                                <i class="fas fa-plus w-4 mr-2"></i>
                                Tambah Kajian
                            </a>
                        </div>
                    </div>
                    
                    <!-- Settings -->
                    <a href="{{ route('admin.settings') }}" 
                       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-sidebar-text hover:bg-sidebar-hover hover:text-white transition-colors {{ request()->routeIs('admin.settings') ? 'bg-sidebar-active text-white' : '' }}">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span class="font-medium">Pengaturan</span>
                    </a>
                </nav>
                
                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-gray-700">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-sidebar-textMuted text-xs">Administrator</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-sm text-sidebar-textMuted hover:text-red-400 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div class="ml-4 lg:ml-0">
                            <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-600"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-circle mr-2"></i>
                                        Profil
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i>
                                        Pengaturan
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-2"></i>
                                                Logout
                                            </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8 fade-in">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="fixed bottom-4 right-4 bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
</body>
</html>
