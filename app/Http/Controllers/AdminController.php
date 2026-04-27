<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use App\Models\Dkm;
use App\Models\Kajian;
use App\Models\User;
use App\Models\Donasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_kajian' => Kajian::count(),
            'total_dkm' => Dkm::count(),
            'total_donations' => Donasi::sum('nominal'),
        ];

        $recentKajian = Kajian::with(['ustadz'])->latest()->take(5)->get();
        $recentDonations = Donasi::with(['user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentKajian', 'recentDonations'));
    }

    // ==================== GALERI MANAGEMENT ====================
    
    public function galeriIndex(Request $request)
    {
        $query = Galeri::query();
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }
        
        // Filter by category
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $galeri = $query->paginate(12);
        
        return view('admin.galeri.index', compact('galeri'));
    }

    public function galeriCreate()
    {
        return view('admin.galeri.create');
    }

    public function galeriStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:kegiatan,masjid,kajian,donasi,lainnya',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::slug($request->judul) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/masjid'), $imageName);
            $data['gambar'] = $imageName;
        }

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function galeriEdit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function galeriUpdate(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:kegiatan,masjid,kajian,donasi,lainnya',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($galeri->gambar && file_exists(public_path('images/masjid/' . $galeri->gambar))) {
                unlink(public_path('images/masjid/' . $galeri->gambar));
            }
            
            $image = $request->file('gambar');
            $imageName = time() . '_' . Str::slug($request->judul) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/masjid'), $imageName);
            $data['gambar'] = $imageName;
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function galeriDestroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        
        // Delete image
        if ($galeri->gambar && file_exists(public_path('images/masjid/' . $galeri->gambar))) {
            unlink(public_path('images/masjid/' . $galeri->gambar));
        }
        
        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }

    // ==================== DKM MANAGEMENT ====================
    
    public function dkmIndex(Request $request)
    {
        $query = Dkm::query();
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }
        
        // Filter by jabatan
        if ($request->has('jabatan') && $request->jabatan) {
            $query->where('jabatan', $request->jabatan);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'jabatan');
        $sortOrder = $request->get('order', 'asc');
        $query->orderBy($sortBy, $sortOrder);
        
        $dkm = $query->paginate(12);
        
        return view('admin.dkm.index', compact('dkm'));
    }

    public function dkmCreate()
    {
        return view('admin.dkm.create');
    }

    public function dkmStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Sekretaris,Bendahara,Anggota',
            'email' => 'nullable|email|max:255|unique:dkm,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:20',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'masa_jabatan' => 'nullable|string|max:50',
            'status' => 'required|in:aktif,tidak_aktif',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');
        
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/dkm'), $imageName);
            $data['foto'] = $imageName;
        }

        Dkm::create($data);

        return redirect()->route('admin.dkm.index')
            ->with('success', 'Anggota DKM berhasil ditambahkan.');
    }

    public function dkmEdit($id)
    {
        $dkm = Dkm::findOrFail($id);
        return view('admin.dkm.edit', compact('dkm'));
    }

    public function dkmUpdate(Request $request, $id)
    {
        $dkm = Dkm::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua,Wakil Ketua,Sekretaris,Bendahara,Anggota',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('dkm', 'email')->ignore($dkm->id),
            ],
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:20',
            'kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'masa_jabatan' => 'nullable|string|max:50',
            'status' => 'required|in:aktif,tidak_aktif',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');
        
        if ($request->hasFile('foto')) {
            // Delete old image
            if ($dkm->foto && file_exists(public_path('images/dkm/' . $dkm->foto))) {
                unlink(public_path('images/dkm/' . $dkm->foto));
            }
            
            $image = $request->file('foto');
            $imageName = time() . '_' . Str::slug($request->nama) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/dkm'), $imageName);
            $data['foto'] = $imageName;
        }

        $dkm->update($data);

        return redirect()->route('admin.dkm.index')
            ->with('success', 'Data anggota DKM berhasil diperbarui.');
    }

    public function dkmDestroy($id)
    {
        $dkm = Dkm::findOrFail($id);
        
        // Delete image
        if ($dkm->foto && file_exists(public_path('images/dkm/' . $dkm->foto))) {
            unlink(public_path('images/dkm/' . $dkm->foto));
        }
        
        $dkm->delete();

        return redirect()->route('admin.dkm.index')
            ->with('success', 'Anggota DKM berhasil dihapus.');
    }

    // ==================== KAJIAN MANAGEMENT ====================
    
    public function kajianIndex(Request $request)
    {
        $query = Kajian::with(['ustadz', 'kitab']);
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('tema', 'like', "%{$search}%")
                  ->orWhere('pemateri', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }
        
        // Filter by hari
        if ($request->has('hari') && $request->hari) {
            $query->where('hari', $request->hari);
        }
        
        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $kajian = $query->paginate(12);
        
        return view('admin.kajian.index', compact('kajian'));
    }

    public function kajianCreate()
    {
        $ustadz = \App\Models\Ustadz::all();
        $kitab = \App\Models\Kitab::all();
        return view('admin.kajian.create', compact('ustadz', 'kitab'));
    }

    public function kajianStore(Request $request)
    {
        $request->validate([
            'tema' => 'required|string|max:255',
            'pemateri' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Ahad',
            'jam' => 'required|string|max:10',
            'lokasi' => 'required|string|max:255',
            'ustadz_id' => 'nullable|exists:ustadz,id',
            'kitab_id' => 'nullable|exists:kitab,id',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        Kajian::create($request->all());

        return redirect()->route('admin.kajian.index')
            ->with('success', 'Jadwal kajian berhasil ditambahkan.');
    }

    public function kajianEdit($id)
    {
        $kajian = Kajian::findOrFail($id);
        $ustadz = \App\Models\Ustadz::all();
        $kitab = \App\Models\Kitab::all();
        return view('admin.kajian.edit', compact('kajian', 'ustadz', 'kitab'));
    }

    public function kajianUpdate(Request $request, $id)
    {
        $kajian = Kajian::findOrFail($id);

        $request->validate([
            'tema' => 'required|string|max:255',
            'pemateri' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Ahad',
            'jam' => 'required|string|max:10',
            'lokasi' => 'required|string|max:255',
            'ustadz_id' => 'nullable|exists:ustadz,id',
            'kitab_id' => 'nullable|exists:kitab,id',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $kajian->update($request->all());

        return redirect()->route('admin.kajian.index')
            ->with('success', 'Jadwal kajian berhasil diperbarui.');
    }

    public function kajianDestroy($id)
    {
        $kajian = Kajian::findOrFail($id);
        $kajian->delete();

        return redirect()->route('admin.kajian.index')
            ->with('success', 'Jadwal kajian berhasil dihapus.');
    }

    // ==================== SETTINGS ====================
    
    public function settings()
    {
        return view('admin.settings');
    }
}
