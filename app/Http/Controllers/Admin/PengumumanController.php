<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PengumumanController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Since we don't have a Pengumuman model, we'll create a simple file-based system
        $pengumuman = $this->getAllPengumuman();
        
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:umum,kajian,donasi,kegiatan,acara',
            'prioritas' => 'required|in:tinggi,sedang,rendah',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,terbit,arsip',
            'tags' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('pengumuman-images', $filename, 'public');
        }

        // Create pengumuman data
        $pengumumanData = [
            'id' => uniqid(),
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'kategori' => $validated['kategori'],
            'prioritas' => $validated['prioritas'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => $validated['status'],
            'tags' => $validated['tags'] ?? '',
            'image' => $imagePath,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ];

        $this->savePengumuman($pengumumanData);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengumuman = $this->getPengumuman($id);
        
        if (!$pengumuman) {
            abort(404);
        }

        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengumuman = $this->getPengumuman($id);
        
        if (!$pengumuman) {
            abort(404);
        }

        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'kategori' => 'required|in:umum,kajian,donasi,kegiatan,acara',
            'prioritas' => 'required|in:tinggi,sedang,rendah',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,terbit,arsip',
            'tags' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $existingPengumuman = $this->getPengumuman($id);
        
        if (!$existingPengumuman) {
            abort(404);
        }

        // Handle image upload
        $imagePath = $existingPengumuman['image'];
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('pengumuman-images', $filename, 'public');
        }

        // Update pengumuman data
        $pengumumanData = [
            'id' => $id,
            'judul' => $validated['judul'],
            'konten' => $validated['konten'],
            'kategori' => $validated['kategori'],
            'prioritas' => $validated['prioritas'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => $validated['status'],
            'tags' => $validated['tags'] ?? '',
            'image' => $imagePath,
            'created_at' => $existingPengumuman['created_at'],
            'updated_at' => now()->toDateTimeString(),
        ];

        $this->savePengumuman($pengumumanData, true);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pengumuman = $this->getPengumuman($id);
        
        if (!$pengumuman) {
            abort(404);
        }

        // Delete image if exists
        if ($pengumuman['image'] && Storage::disk('public')->exists($pengumuman['image'])) {
            Storage::disk('public')->delete($pengumuman['image']);
        }

        $this->deletePengumuman($id);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    /**
     * Toggle pengumuman status
     */
    public function toggleStatus($id)
    {
        $pengumuman = $this->getPengumuman($id);
        
        if (!$pengumuman) {
            abort(404);
        }

        $newStatus = $pengumuman['status'] === 'terbit' ? 'draft' : 'terbit';
        
        $pengumumanData = $pengumuman;
        $pengumumanData['status'] = $newStatus;
        $pengumumanData['updated_at'] = now()->toDateTimeString();

        $this->savePengumuman($pengumumanData, true);

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Status pengumuman berhasil diperbarui.');
    }

    /**
     * Search pengumuman
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $pengumuman = $this->searchPengumuman($query);

        return view('admin.pengumuman.index', compact('pengumuman', 'query'));
    }

    /**
     * Get all pengumuman from storage
     */
    private function getAllPengumuman()
    {
        $storagePath = storage_path('app/data/pengumuman.json');
        
        if (!file_exists($storagePath)) {
            // Create directory if not exists
            $dir = dirname($storagePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Create empty file
            file_put_contents($storagePath, json_encode([]));
            return [];
        }

        $data = json_decode(file_get_contents($storagePath), true);
        
        // Sort by priority and date
        usort($data, function ($a, $b) {
            $priorityOrder = ['tinggi' => 1, 'sedang' => 2, 'rendah' => 3];
            
            if ($priorityOrder[$a['prioritas']] != $priorityOrder[$b['prioritas']]) {
                return $priorityOrder[$a['prioritas']] - $priorityOrder[$b['prioritas']];
            }
            
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $data;
    }

    /**
     * Get single pengumuman by ID
     */
    private function getPengumuman($id)
    {
        $pengumuman = $this->getAllPengumuman();
        
        foreach ($pengumuman as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        
        return null;
    }

    /**
     * Save pengumuman to storage
     */
    private function savePengumuman($data, $update = false)
    {
        $storagePath = storage_path('app/data/pengumuman.json');
        $pengumuman = $this->getAllPengumuman();
        
        if ($update) {
            // Update existing
            foreach ($pengumuman as $key => $item) {
                if ($item['id'] === $data['id']) {
                    $pengumuman[$key] = $data;
                    break;
                }
            }
        } else {
            // Add new
            $pengumuman[] = $data;
        }
        
        file_put_contents($storagePath, json_encode($pengumuman, JSON_PRETTY_PRINT));
    }

    /**
     * Delete pengumuman from storage
     */
    private function deletePengumuman($id)
    {
        $storagePath = storage_path('app/data/pengumuman.json');
        $pengumuman = $this->getAllPengumuman();
        
        $pengumuman = array_filter($pengumuman, function ($item) use ($id) {
            return $item['id'] !== $id;
        });
        
        file_put_contents($storagePath, json_encode(array_values($pengumuman), JSON_PRETTY_PRINT));
    }

    /**
     * Search pengumuman
     */
    private function searchPengumuman($query)
    {
        $pengumuman = $this->getAllPengumuman();
        $query = strtolower($query);
        
        return array_filter($pengumuman, function ($item) use ($query) {
            return strpos(strtolower($item['judul']), $query) !== false ||
                   strpos(strtolower($item['konten']), $query) !== false ||
                   strpos(strtolower($item['kategori']), $query) !== false ||
                   strpos(strtolower($item['tags']), $query) !== false;
        });
    }
}
