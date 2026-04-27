@extends('layouts.admin')

@section('title', 'Manajemen Struktur DKM')

@section('page-title', 'Manajemen Struktur DKM')

@section('content')
<!-- Header -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Struktur DKM</h1>
            <p class="text-gray-600 mt-1">Kelola data anggota Dewan Kemakmuran Masjid</p>
        </div>
        <a href="{{ route('admin.dkm.create') }}" 
           class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-user-plus"></i>
            <span>Tambah Anggota</span>
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Anggota</label>
            <div class="relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari berdasarkan nama, jabatan, atau email..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Jabatan</label>
            <select id="jabatanFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <option value="">Semua Jabatan</option>
                <option value="Ketua">Ketua</option>
                <option value="Wakil Ketua">Wakil Ketua</option>
                <option value="Sekretaris">Sekretaris</option>
                <option value="Bendahara">Bendahara</option>
                <option value="Anggota">Anggota</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
            <select id="sortFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <option value="jabatan">Jabatan</option>
                <option value="nama">Nama (A-Z)</option>
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
            </select>
        </div>
    </div>
</div>

<!-- DKM List -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">
            Daftar Anggota DKM 
            <span class="text-sm text-gray-600 ml-2">({{ $dkm->count() }} anggota)</span>
        </h2>
        <div class="flex items-center space-x-2">
            <button id="gridView" class="p-2 text-primary-600 bg-primary-50 rounded-lg">
                <i class="fas fa-th-large"></i>
            </button>
            <button id="listView" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    
    <div id="dkmContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @if($dkm->count() > 0)
            @foreach($dkm as $member)
                <div class="dkm-item bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all duration-300" 
                     data-name="{{ strtolower($member->nama ?? '') }}" 
                     data-jabatan="{{ $member->jabatan ?? '' }}"
                     data-date="{{ $member->created_at->timestamp }}">
                    
                    <!-- Profile Header -->
                    <div class="text-center mb-4">
                        <div class="w-20 h-20 bg-primary-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                            @if($member->foto)
                                <img src="{{ asset('images/dkm/' . $member->foto) }}" 
                                     alt="{{ $member->nama }}"
                                     class="w-full h-full rounded-full object-cover"
                                     onerror="this.parentElement.innerHTML='<i class=\\'fas fa-user text-primary-600 text-2xl\\'></i>'">
                            @else
                                <i class="fas fa-user text-primary-600 text-2xl"></i>
                            @endif
                        </div>
                        
                        <h3 class="font-semibold text-gray-900 text-lg">{{ $member->nama ?? 'Tanpa Nama' }}</h3>
                        
                        <div class="flex items-center justify-center mt-2">
                            <span class="px-3 py-1 bg-primary-100 text-primary-700 text-xs font-medium rounded-full">
                                {{ $member->jabatan ?? 'Anggota' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="space-y-2 mb-4">
                        @if($member->email)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-envelope w-4 text-center mr-2 text-gray-400"></i>
                                <span class="truncate">{{ $member->email }}</span>
                            </div>
                        @endif
                        
                        @if($member->no_hp)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-phone w-4 text-center mr-2 text-gray-400"></i>
                                <span>{{ $member->no_hp }}</span>
                            </div>
                        @endif
                        
                        @if($member->alamat)
                            <div class="flex items-start text-sm text-gray-600">
                                <i class="fas fa-map-marker-alt w-4 text-center mr-2 text-gray-400 mt-0.5"></i>
                                <span class="line-clamp-2">{{ $member->alamat }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center space-x-2">
                            <a href="tel:{{ $member->no_hp ?? '#' }}" 
                               @if($member->no_hp)
                               class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                               @else
                               class="p-2 text-gray-400 cursor-not-allowed"
                               @endif>
                                <i class="fas fa-phone"></i>
                            </a>
                            <a href="mailto:{{ $member->email ?? '#' }}" 
                               @if($member->email)
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                               @else
                               class="p-2 text-gray-400 cursor-not-allowed"
                               @endif>
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->no_hp ?? '') }}" 
                               @if($member->no_hp)
                               target="_blank"
                               class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                               @else
                               class="p-2 text-gray-400 cursor-not-allowed"
                               @endif>
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                        
                        <div class="flex items-center space-x-1">
                            <a href="{{ route('admin.dkm.edit', $member->id) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $member->id }}, '{{ $member->nama ?? 'Anggota' }}')" 
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="mt-3 text-center">
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $member->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full text-center py-12">
                <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Anggota DKM</h3>
                <p class="text-gray-600 mb-4">Mulai dengan menambahkan anggota DKM pertama</p>
                <a href="{{ route('admin.dkm.create') }}" 
                   class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg inline-flex items-center space-x-2 transition-colors">
                    <i class="fas fa-user-plus"></i>
                    <span>Tambah Anggota Pertama</span>
                </a>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if($dkm->hasPages())
        <div class="mt-8">
            {{ $dkm->links() }}
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Hapus Anggota DKM</h3>
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus <span id="memberName" class="font-semibold"></span> dari daftar DKM?</p>
            </div>
        </div>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Anggota</p>
                <p class="text-2xl font-bold text-gray-900">{{ $dkm->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Ketua & Wakil</p>
                <p class="text-2xl font-bold text-gray-900">{{ $dkm->whereIn('jabatan', ['Ketua', 'Wakil Ketua'])->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-tie text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Sekretaris & Bendahara</p>
                <p class="text-2xl font-bold text-gray-900">{{ $dkm->whereIn('jabatan', ['Sekretaris', 'Bendahara'])->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clipboard text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Anggota Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ $dkm->where('jabatan', 'Anggota')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-user text-yellow-600"></i>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', filterDKM);
document.getElementById('jabatanFilter').addEventListener('change', filterDKM);
document.getElementById('sortFilter').addEventListener('change', filterDKM);

function filterDKM() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const jabatanFilter = document.getElementById('jabatanFilter').value;
    const sortBy = document.getElementById('sortFilter').value;
    
    const items = document.querySelectorAll('.dkm-item');
    const container = document.getElementById('dkmContainer');
    
    // Filter items
    const filteredItems = Array.from(items).filter(item => {
        const name = item.dataset.name;
        const jabatan = item.dataset.jabatan;
        
        const matchesSearch = name.includes(searchTerm);
        const matchesJabatan = !jabatanFilter || jabatan === jabatanFilter;
        
        return matchesSearch && matchesJabatan;
    });
    
    // Sort items
    filteredItems.sort((a, b) => {
        switch(sortBy) {
            case 'jabatan':
                const jabatanOrder = {'Ketua': 0, 'Wakil Ketua': 1, 'Sekretaris': 2, 'Bendahara': 3, 'Anggota': 4};
                const aJabatan = jabatanOrder[a.dataset.jabatan] ?? 5;
                const bJabatan = jabatanOrder[b.dataset.jabatan] ?? 5;
                return aJabatan - bJabatan;
            case 'nama':
                return a.dataset.name.localeCompare(b.dataset.name);
            case 'newest':
                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            case 'oldest':
                return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            default:
                return 0;
        }
    });
    
    // Reorder DOM
    filteredItems.forEach(item => container.appendChild(item));
    
    // Show/hide items
    items.forEach(item => {
        item.style.display = filteredItems.includes(item) ? 'block' : 'none';
    });
}

// Delete confirmation
function confirmDelete(id, name) {
    document.getElementById('memberName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/dkm/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// View toggle
document.getElementById('gridView').addEventListener('click', function() {
    document.getElementById('dkmContainer').className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6';
    this.classList.add('text-primary-600', 'bg-primary-50');
    this.classList.remove('text-gray-600', 'hover:bg-gray-100');
    document.getElementById('listView').classList.remove('text-primary-600', 'bg-primary-50');
    document.getElementById('listView').classList.add('text-gray-600', 'hover:bg-gray-100');
});

document.getElementById('listView').addEventListener('click', function() {
    document.getElementById('dkmContainer').className = 'space-y-4';
    this.classList.add('text-primary-600', 'bg-primary-50');
    this.classList.remove('text-gray-600', 'hover:bg-gray-100');
    document.getElementById('gridView').classList.remove('text-primary-600', 'bg-primary-50');
    document.getElementById('gridView').classList.add('text-gray-600', 'hover:bg-gray-100');
});

// Close modal on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// Auto-refresh statistics every 30 seconds
setInterval(() => {
    // You could implement AJAX to refresh statistics here
    console.log('Statistics refreshed');
}, 30000);
</script>
@endsection
