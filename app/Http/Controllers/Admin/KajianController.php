<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kajian;
use App\Models\Ustadz;
use App\Models\Kitab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KajianController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kajians = Kajian::with(['ustadz', 'kitab'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.kajian.index-simple', compact('kajians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ustadzs = Ustadz::orderBy('nama')->get();
        $kitabs = Kitab::orderBy('nama')->get();

        return view('admin.kajian.create-simple', compact('ustadzs', 'kitabs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ustadz_id' => 'required|exists:ustadz,id',
            'kitab_id' => 'nullable|exists:kitab,id',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'link_youtube' => 'nullable|url|max:500',
            'link_streaming' => 'nullable|url|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,tidak aktif',
            'kategori' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kajian-images', $filename, 'public');
            $validated['image'] = $path;
        }

        // Auto-infer category if not provided
        if (empty($validated['kategori'])) {
            $validated['kategori'] = $this->inferKajianKategori(
                $validated['judul'], 
                Kitab::find($validated['kitab_id'] ?? 0)?->nama, 
                $validated['deskripsi']
            );
        }

        Kajian::create($validated);

        return redirect()
            ->route('admin.kajian.index')
            ->with('success', 'Kajian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kajian $kajian)
    {
        $kajian->load(['ustadz', 'kitab', 'ratings']);
        return view('admin.kajian.show', compact('kajian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kajian $kajian)
    {
        $ustadzs = Ustadz::orderBy('nama')->get();
        $kitabs = Kitab::orderBy('nama')->get();

        return view('admin.kajian.edit', compact('kajian', 'ustadzs', 'kitabs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kajian $kajian)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ustadz_id' => 'required|exists:ustadz,id',
            'kitab_id' => 'nullable|exists:kitab,id',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'link_youtube' => 'nullable|url|max:500',
            'link_streaming' => 'nullable|url|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,tidak aktif',
            'kategori' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($kajian->image && Storage::disk('public')->exists($kajian->image)) {
                Storage::disk('public')->delete($kajian->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kajian-images', $filename, 'public');
            $validated['image'] = $path;
        }

        // Auto-infer category if not provided
        if (empty($validated['kategori'])) {
            $validated['kategori'] = $this->inferKajianKategori(
                $validated['judul'], 
                Kitab::find($validated['kitab_id'] ?? 0)?->nama, 
                $validated['deskripsi']
            );
        }

        $kajian->update($validated);

        return redirect()
            ->route('admin.kajian.index')
            ->with('success', 'Data kajian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kajian $kajian)
    {
        // Delete image if exists
        if ($kajian->image && Storage::disk('public')->exists($kajian->image)) {
            Storage::disk('public')->delete($kajian->image);
        }

        $kajian->delete();

        return redirect()
            ->route('admin.kajian.index')
            ->with('success', 'Kajian berhasil dihapus.');
    }

    /**
     * Bulk delete kajian
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:kajians,id',
        ]);

        $kajians = Kajian::whereIn('id', $validated['ids'])->get();

        foreach ($kajians as $kajian) {
            if ($kajian->image && Storage::disk('public')->exists($kajian->image)) {
                Storage::disk('public')->delete($kajian->image);
            }
            $kajian->delete();
        }

        return redirect()
            ->route('admin.kajian.index')
            ->with('success', count($validated['ids']) . ' kajian berhasil dihapus.');
    }

    /**
     * Search kajian
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $kajians = Kajian::with(['ustadz', 'kitab'])
            ->where('judul', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->orWhereHas('ustadz', function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%");
            })
            ->orWhereHas('kitab', function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.kajian.index', compact('kajians', 'query'));
    }

    /**
     * Toggle kajian status
     */
    public function toggleStatus(Kajian $kajian)
    {
        $kajian->status = $kajian->status === 'aktif' ? 'tidak aktif' : 'aktif';
        $kajian->save();

        return redirect()
            ->route('admin.kajian.index')
            ->with('success', 'Status kajian berhasil diperbarui.');
    }

    /**
     * Infer kajian category from content
     */
    private function inferKajianKategori(?string $judul, ?string $kitabNama, ?string $deskripsi): string
    {
        $text = strtolower(trim(implode(' ', array_filter([
            $judul,
            $kitabNama,
            $deskripsi,
        ]))));

        $map = [
            'Aqidah' => ['aqidah', 'tauhid', 'ushul', 'iman'],
            'Sirah' => ['sirah', 'siroh', 'nabawiyah', 'rasul', 'sejarah'],
            'Al-Quran' => ['al-quran', 'alquran', 'quran', 'tafsir'],
            'Tazkiyah' => ['tazkiyah', 'tazkiyatun', 'penyucian jiwa', 'nufus'],
            'Akhlak' => ['akhlak', 'adab'],
            'Fiqih' => ['fiqih', 'fikih', 'thaharah', 'shalat', 'zakat', 'puasa', 'haji', 'ibadah'],
            'Hadits' => ['hadits', 'hadis', 'riyadussholihin', 'riyadhus shalihin', 'arba', 'bukhari', 'muslim'],
            'Muamalah' => ['muamalah', 'ekonomi', 'waris', 'jual beli', 'nikah'],
        ];

        foreach ($map as $kategori => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    return $kategori;
                }
            }
        }

        return 'Dakwah Umum';
    }
}
