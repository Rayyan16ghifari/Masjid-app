<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen DKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Manajemen DKM</h1>
                        <p class="text-gray-600 mt-1">Kelola data anggota Dewan Kemakmuran Masjid</p>
                    </div>
                    <a href="{{ route('admin.dkm.create') }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah Anggota
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Anggota</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $dkmMembers->total() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $dkmMembers->whereIn('jabatan', ['Ketua', 'Wakil Ketua'])->count() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $dkmMembers->whereIn('jabatan', ['Sekretaris', 'Bendahara'])->count() }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ $dkmMembers->where('jabatan', 'Anggota')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-yellow-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Anggota</label>
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Cari berdasarkan nama, jabatan, atau email..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Jabatan</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                        <span class="text-sm text-gray-600 ml-2">({{ $dkmMembers->count() }} anggota)</span>
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-th-large mr-1"></i>
                            Grid
                        </button>
                        <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-list mr-1"></i>
                            List
                        </button>
                    </div>
                </div>
                
                @if($dkmMembers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($dkmMembers as $member)
                            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <!-- Profile Header -->
                                <div class="text-center mb-4">
                                    <div class="w-20 h-20 bg-blue-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                                        @if($member->foto)
                                            <img src="{{ asset('images/dkm-photos/' . $member->foto) }}" 
                                                 alt="{{ $member->nama }}"
                                                 class="w-full h-full rounded-full object-cover"
                                                 onerror="this.parentElement.innerHTML='<i class=\\'fas fa-user text-blue-600 text-2xl\\'></i>'">
                                        @else
                                            <i class="fas fa-user text-blue-600 text-2xl"></i>
                                        @endif
                                    </div>
                                    
                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $member->nama ?? 'Tanpa Nama' }}</h3>
                                    
                                    <div class="flex items-center justify-center mt-2">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
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
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        @if($member->no_hp)
                                            <a href="tel:{{ $member->no_hp }}" 
                                               class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                                <i class="fas fa-phone"></i>
                                            </a>
                                        @endif
                                        @if($member->email)
                                            <a href="mailto:{{ $member->email }}" 
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        @endif
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->no_hp ?? '') }}" 
                                           @if($member->no_hp)
                                           target="_blank"
                                           @endif
                                           class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
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
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $dkmMembers->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Anggota DKM</h3>
                        <p class="text-gray-600 mb-4">Mulai dengan menambahkan anggota DKM pertama</p>
                        <a href="{{ route('admin.dkm.create') }}" 
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg inline-flex items-center space-x-2 transition-colors">
                            <i class="fas fa-user-plus"></i>
                            <span>Tambah Anggota Pertama</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id, name) {
        if (confirm(`Apakah Anda yakin ingin menghapus anggota "${name}" dari DKM?`)) {
            // Create form for deletion
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/dkm/${id}`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
</body>
</html>
