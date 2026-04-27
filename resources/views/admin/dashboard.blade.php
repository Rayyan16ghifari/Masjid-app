@extends('layouts.admin')

@section('title', 'Admin Dashboard - Al-Hasanah App')

@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Pengguna</p>
                <p class="text-2xl font-bold text-gray-900">{{ App\Models\User::count() }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    12% dari bulan lalu
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Kajian -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Kajian</p>
                <p class="text-2xl font-bold text-gray-900">{{ App\Models\Kajian::count() }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    8% dari bulan lalu
                </p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-book text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Total DKM -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Anggota DKM</p>
                <p class="text-2xl font-bold text-gray-900">{{ App\Models\Dkm::count() }}</p>
                <p class="text-xs text-gray-600 mt-1">
                    <i class="fas fa-minus mr-1"></i>
                    Tidak ada perubahan
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-tie text-purple-600"></i>
            </div>
        </div>
    </div>

    <!-- Total Donasi -->
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Donasi</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(App\Models\Donasi::sum('nominal'), 0, ',', '.') }}</p>
                <p class="text-xs text-green-600 mt-1">
                    <i class="fas fa-arrow-up mr-1"></i>
                    25% dari bulan lalu
                </p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-donate text-yellow-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.galeri.create') }}" 
           class="flex items-center justify-center p-4 bg-primary-50 hover:bg-primary-100 rounded-lg transition-colors group">
            <div class="text-center">
                <div class="w-12 h-12 bg-primary-600 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-images text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-900">Tambah Galeri</p>
            </div>
        </a>

        <a href="{{ route('admin.dkm.create') }}" 
           class="flex items-center justify-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
            <div class="text-center">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-900">Tambah DKM</p>
            </div>
        </a>

        <a href="{{ route('admin.kajian.create') }}" 
           class="flex items-center justify-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-calendar-plus text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-900">Tambah Kajian</p>
            </div>
        </a>

        <a href="{{ route('admin.pengumuman.create') }}" 
           class="flex items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
            <div class="text-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:scale-110 transition-transform">
                    <i class="fas fa-bullhorn text-white"></i>
                </div>
                <p class="text-sm font-medium text-gray-900">Tambah Pengumuman</p>
            </div>
        </a>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Kajian -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Kajian Terbaru</h2>
            <a href="{{ route('admin.kajian.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-3">
            @php
                $recentKajian = App\Models\Kajian::with(['ustadz'])->latest()->take(5)->get();
            @endphp
            @if($recentKajian->count() > 0)
                @foreach($recentKajian as $kajian)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $kajian->tema }}</p>
                            <p class="text-xs text-gray-600">{{ $kajian->ustadz->nama ?? 'Tidak ada ustadz' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-600">{{ $kajian->hari }}</p>
                            <p class="text-xs text-gray-600">{{ $kajian->jam }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-alt text-gray-400 text-2xl mb-2"></i>
                    <p class="text-gray-600">Belum ada kajian</p>
                    <a href="{{ route('admin.kajian.create') }}" class="text-sm text-primary-600 hover:text-primary-700 mt-2 inline-block">
                        Tambah Kajian Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Donations -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Donasi Terbaru</h2>
            <a href="/donasi/history" class="text-sm text-primary-600 hover:text-primary-700">
                Lihat Semua →
            </a>
        </div>
        <div class="space-y-3">
            @php
                $recentDonations = App\Models\Donasi::with(['user'])->latest()->take(5)->get();
            @endphp
            @if($recentDonations->count() > 0)
                @foreach($recentDonations as $donation)
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $donation->user->name ?? 'Anonymous' }}</p>
                            <p class="text-xs text-gray-600">{{ $donation->metode_pembayaran ?? 'Tunai' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-green-600">Rp {{ number_format($donation->nominal, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-600">{{ $donation->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8">
                    <i class="fas fa-donate text-gray-400 text-2xl mb-2"></i>
                    <p class="text-gray-600">Belum ada donasi</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
