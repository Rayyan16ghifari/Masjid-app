<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Al-Hasanah App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-card {
            background: linear-gradient(135deg, var(--gradient-from), var(--gradient-to));
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .chart-container {
            position: relative;
            height: 300px;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar-item {
            transition: all 0.3s ease;
        }
        .sidebar-item:hover {
            background: rgba(16, 185, 129, 0.1);
            border-left: 3px solid rgb(16, 185, 129);
            padding-left: 12px;
        }
        .sidebar-item.active {
            background: rgba(16, 185, 129, 0.1);
            border-left: 3px solid rgb(16, 185, 129);
            padding-left: 12px;
        }
        .dropdown-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dropdown-sidebar.open {
            transform: translateX(0);
        }
        .main-content {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .main-content.shifted {
            margin-left: 280px;
        }
        .menu-button {
            transition: all 0.3s ease;
        }
        .menu-button:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
        }
        .menu-button.active {
            background: linear-gradient(135deg, rgb(16, 185, 129), rgb(5, 150, 105));
            transform: scale(1.05);
        }
        .overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .overlay.active {
            opacity: 1;
            pointer-events: all;
        }
        @keyframes slideInFromLeft {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .sidebar-enter {
            animation: slideInFromLeft 0.3s ease-out;
        }
        .overlay-enter {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-green-50 to-white min-h-screen">
    <!-- Menu Button (Floating) -->
    <button id="menuButton" onclick="toggleSidebar()"
            class="menu-button fixed top-6 left-6 z-50 w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl">
        <i class="fas fa-bars text-white text-xl"></i>
    </button>

    <!-- Overlay -->
    <div id="overlay" class="overlay fixed inset-0 bg-black bg-opacity-50 z-40"></div>

    <!-- Dropdown Sidebar -->
    <div id="sidebar" class="dropdown-sidebar fixed left-0 top-0 h-full w-80 bg-white shadow-2xl z-50">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-mosque text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">Al-Hasanah</h3>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>
        </div>

        <!-- User Profile -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-green-700 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500">Administrator</p>
                    <p class="text-xs text-emerald-600 mt-1">
                        <i class="fas fa-circle text-xs mr-1"></i>Online
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="p-4 overflow-y-auto" style="max-height: calc(100vh - 280px);">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-item active flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Galeri -->
                <a href="{{ route('admin.galeri.index') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-images w-5 text-center"></i>
                    <span>Galeri</span>
                </a>

                <!-- Kajian -->
                <a href="{{ route('admin.kajian.index') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-book w-5 text-center"></i>
                    <span>Kajian</span>
                </a>

                <!-- DKM -->
                <a href="{{ route('admin.dkm.index') }}" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-user-tie w-5 text-center"></i>
                    <span>Struktur DKM</span>
                </a>

                <!-- Pengumuman -->
                <a href="#" onclick="showNotification('Pengumuman module coming soon', 'info'); return false;" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-bullhorn w-5 text-center"></i>
                    <span>Pengumuman</span>
                </a>

                <!-- Donasi -->
                <a href="#" onclick="showNotification('Donasi module coming soon', 'info'); return false;" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-donate w-5 text-center"></i>
                    <span>Donasi</span>
                </a>

                <!-- Users -->
                <a href="#" onclick="showNotification('User management coming soon', 'info'); return false;" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span>Users</span>
                </a>

                <!-- Settings -->
                <a href="#" onclick="showNotification('Settings module coming soon', 'info'); return false;" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </div>

            <!-- Divider -->
            <div class="my-6 border-t border-gray-200"></div>

            <!-- System Menu -->
            <div class="space-y-2">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">System</h4>
                
                <!-- Reports -->
                <a href="#" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-chart-bar w-5 text-center"></i>
                    <span>Reports</span>
                </a>

                <!-- Logs -->
                <a href="#" 
                   class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-file-alt w-5 text-center"></i>
                    <span>Logs</span>
                </a>

                <!-- Backup -->
                <button onclick="showNotification('Backup functionality coming soon', 'info')" 
                       class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:text-emerald-600 w-full text-left">
                    <i class="fas fa-database w-5 text-center"></i>
                    <span>Backup</span>
                </button>
            </div>

            <!-- Divider -->
            <div class="my-6 border-t border-gray-200"></div>

            <!-- Quick Stats -->
            <div class="px-3 pb-4">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Quick Stats</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-emerald-50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-emerald-600">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-gray-600">Users</p>
                    </div>
                    <div class="bg-teal-50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-teal-600">{{ $stats['total_kajian'] }}</p>
                        <p class="text-xs text-gray-600">Kajian</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $stats['total_dkm'] }}</p>
                        <p class="text-xs text-gray-600">DKM</p>
                    </div>
                    <div class="bg-lime-50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-lime-600">{{ $stats['total_media'] }}</p>
                        <p class="text-xs text-gray-600">Media</p>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>Version 1.0.0</span>
                <span>© 2024</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="mainContent" class="main-content min-h-screen">
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8 mb-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-chart-line text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                                <p class="text-gray-600 mt-1">Monitor dan kelola seluruh sistem masjid</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button class="p-3 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                <i class="fas fa-bell text-gray-600"></i>
                            </button>
                            <button class="p-3 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                <i class="fas fa-search text-gray-600"></i>
                            </button>
                            <button onclick="toggleSidebar()" class="p-3 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                                <i class="fas fa-th text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users -->
                    <div class="stats-card rounded-2xl p-6 text-white shadow-xl" style="--gradient-from: rgb(16, 185, 129); --gradient-to: rgb(5, 150, 105);">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-1">Total Users</p>
                            <p class="text-3xl font-bold mb-2">{{ $stats['total_users'] }}</p>
                            <div class="flex items-center text-xs text-emerald-100">
                                @if($userGrowthPercentage > 0)
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>+{{ number_format($userGrowthPercentage, 1) }}% dari bulan lalu</span>
                                @elseif($userGrowthPercentage < 0)
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>{{ number_format($userGrowthPercentage, 1) }}% dari bulan lalu</span>
                                @else
                                    <i class="fas fa-equals mr-1"></i>
                                    <span>Sama dengan bulan lalu</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Total Kajian -->
                    <div class="stats-card rounded-2xl p-6 text-white shadow-xl" style="--gradient-from: rgb(20, 184, 166); --gradient-to: rgb(13, 148, 136);">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-book text-2xl"></i>
                            </div>
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-teal-100 text-sm font-medium mb-1">Total Kajian</p>
                            <p class="text-3xl font-bold mb-2">{{ $stats['total_kajian'] }}</p>
                            <div class="flex items-center text-xs text-teal-100">
                                @if($kajianGrowthPercentage > 0)
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>+{{ number_format($kajianGrowthPercentage, 1) }}% dari bulan lalu</span>
                                @elseif($kajianGrowthPercentage < 0)
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>{{ number_format($kajianGrowthPercentage, 1) }}% dari bulan lalu</span>
                                @else
                                    <i class="fas fa-equals mr-1"></i>
                                    <span>Sama dengan bulan lalu</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Total DKM -->
                    <div class="stats-card rounded-2xl p-6 text-white shadow-xl" style="--gradient-from: rgb(34, 197, 94); --gradient-to: rgb(22, 163, 74);">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-tie text-2xl"></i>
                            </div>
                            <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-green-100 text-sm font-medium mb-1">Total DKM</p>
                            <p class="text-3xl font-bold mb-2">{{ $stats['total_dkm'] }}</p>
                            <div class="flex items-center text-xs text-green-100">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span>{{ $dkmStructure['Ketua'] + $dkmStructure['Wakil Ketua'] }} pimpinan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Media -->
                    <div class="stats-card rounded-2xl p-6 text-white shadow-xl" style="--gradient-from: rgb(132, 204, 22); --gradient-to: rgb(101, 163, 13);">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-photo-video text-2xl"></i>
                            </div>
                            <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-lime-100 text-sm font-medium mb-1">Total Dokumentasi</p>
                            <p class="text-3xl font-bold mb-2">{{ $stats['total_media'] }}</p>
                            <div class="flex items-center text-xs text-lime-100">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span>{{ $stats['total_videos'] }} video</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- User Growth Chart -->
                    <div class="glass-effect rounded-2xl shadow-xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Jumlah Akses Jama'ah</h2>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-sm">7 Hari</button>
                                <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm">30 Hari</button>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>

                    <!-- Kajian Distribution Chart -->
                    <div class="glass-effect rounded-2xl shadow-xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Aktivitas Kajian</h2>
                            <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                        </div>
                        <div class="chart-container">
                            <canvas id="kajianDistributionChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Additional Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <!-- User Roles Chart -->
                    <div class="glass-effect rounded-2xl shadow-xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Peran Pengguna</h2>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="userRolesChart"></canvas>
                        </div>
                    </div>

                    <!-- DKM Structure Chart -->
                    <div class="glass-effect rounded-2xl shadow-xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Struktur DKM</h2>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="dkmStructureChart"></canvas>
                        </div>
                    </div>

                    <!-- Activity Timeline Chart -->
                    <div class="glass-effect rounded-2xl shadow-xl p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Aktivitas Harian</h2>
                        <div class="chart-container" style="height: 200px;">
                            <canvas id="activityTimelineChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="glass-effect rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('admin.galeri.create') }}" 
                           class="block p-4 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-200 hover:shadow-lg transition-all">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                                <p class="font-semibold text-gray-900">Tambah Media</p>
                                <p class="text-sm text-gray-600">Upload foto/video</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.kajian.create') }}" 
                           class="block p-4 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border border-teal-200 hover:shadow-lg transition-all">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-calendar-plus text-white"></i>
                                </div>
                                <p class="font-semibold text-gray-900">Jadwalkan Kajian</p>
                                <p class="text-sm text-gray-600">Tambah jadwal baru</p>
                            </div>
                        </a>

                        <button onclick="showNotification('Pengumuman module coming soon', 'info')" 
                           class="block p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200 hover:shadow-lg transition-all w-full">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-bullhorn text-white"></i>
                                </div>
                                <p class="font-semibold text-gray-900">Buat Pengumuman</p>
                                <p class="text-sm text-gray-600">Informasi terbaru</p>
                            </div>
                        </button>

                        <button onclick="showNotification('Backup functionality coming soon', 'info')" 
                               class="block p-4 bg-gradient-to-r from-lime-50 to-green-50 rounded-xl border border-lime-200 hover:shadow-lg transition-all">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-lime-500 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-database text-white"></i>
                                </div>
                                <p class="font-semibold text-gray-900">Backup Data</p>
                                <p class="text-sm text-gray-600">Simpan data sistem</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden">
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span id="notificationText">Success!</span>
        </div>
    </div>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mainContent = document.getElementById('mainContent');
            const menuButton = document.getElementById('menuButton');
            
            if (sidebar.classList.contains('open')) {
                // Close sidebar
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                mainContent.classList.remove('shifted');
                menuButton.classList.remove('active');
            } else {
                // Open sidebar
                sidebar.classList.add('open');
                overlay.classList.add('active');
                mainContent.classList.add('shifted');
                menuButton.classList.add('active');
            }
        }

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', toggleSidebar);

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('open')) {
                    toggleSidebar();
                }
            }
        });

        // Chart configurations
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        };

        // User Growth Chart - Real-time Data
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: @json(array_column($userGrowthData, 'date')),
                datasets: [{
                    label: 'Pengguna Baru',
                    data: @json(array_column($userGrowthData, 'new_users')),
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Total Pengguna',
                    data: @json(array_column($userGrowthData, 'total_users')),
                    borderColor: 'rgb(5, 150, 105)',
                    backgroundColor: 'rgba(5, 150, 105, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: chartOptions
        });

        // Kajian Distribution Chart - Real-time Data
        const kajianCtx = document.getElementById('kajianDistributionChart').getContext('2d');
        new Chart(kajianCtx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($kajianCategories)),
                datasets: [{
                    data: @json(array_values($kajianCategories)),
                    backgroundColor: [
                        'rgb(16, 185, 129)',
                        'rgb(20, 184, 166)',
                        'rgb(34, 197, 94)',
                        'rgb(132, 204, 22)',
                        'rgb(251, 146, 60)',
                        'rgb(107, 114, 128)'
                    ]
                }]
            },
            options: chartOptions
        });

        // User Roles Chart - Real-time Data
        const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
        new Chart(userRolesCtx, {
            type: 'pie',
            data: {
                labels: @json(array_keys($userRoles)),
                datasets: [{
                    data: @json(array_values($userRoles)),
                    backgroundColor: [
                        'rgb(239, 68, 68)',
                        'rgb(16, 185, 129)',
                        'rgb(20, 184, 166)',
                        'rgb(34, 197, 94)'
                    ]
                }]
            },
            options: chartOptions
        });

        // DKM Structure Chart - Real-time Data
        const dkmCtx = document.getElementById('dkmStructureChart').getContext('2d');
        new Chart(dkmCtx, {
            type: 'bar',
            data: {
                labels: @json(array_keys($dkmStructure)),
                datasets: [{
                    label: 'Jumlah',
                    data: @json(array_values($dkmStructure)),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Activity Timeline Chart - Real-time Data
        const activityCtx = document.getElementById('activityTimelineChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: @json($activityTimeline->pluck('time')->toArray()),
                datasets: [{
                    label: 'Aktivitas',
                    data: @json($activityTimeline->map(function($item) {
                        return rand(1, 10); // Generate random activity count for demonstration
                    })->toArray()),
                    backgroundColor: 'rgba(20, 184, 166, 0.8)',
                    borderColor: 'rgb(20, 184, 166)',
                    borderWidth: 1
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Sidebar toggle function
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mainContent = document.getElementById('mainContent');
            const menuButton = document.getElementById('menuButton');
            
            if (sidebar.classList.contains('open')) {
                // Close sidebar
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                mainContent.classList.remove('shifted');
                menuButton.classList.remove('active');
            } else {
                // Open sidebar
                sidebar.classList.add('open');
                overlay.classList.add('active');
                mainContent.classList.add('shifted');
                menuButton.classList.add('active');
            }
        }

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', toggleSidebar);

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('open')) {
                    toggleSidebar();
                }
            }
        });

        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const notificationText = document.getElementById('notificationText');
            
            notificationText.textContent = message;
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 ${
                type === 'success' ? 'bg-green-500 text-white' : 
                type === 'error' ? 'bg-red-500 text-white' : 
                'bg-blue-500 text-white'
            }`;
            
            notification.classList.remove('hidden');
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate numbers on load
            document.querySelectorAll('.text-3xl').forEach(element => {
                const value = parseInt(element.textContent);
                if (!isNaN(value)) {
                    let current = 0;
                    const increment = value / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= value) {
                            current = value;
                            clearInterval(timer);
                        }
                        element.textContent = Math.floor(current);
                    }, 30);
                }
            });
        });
    </script>
</body>
</html>
