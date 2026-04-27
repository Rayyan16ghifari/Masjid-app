<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = [];
        $videos = [];
        
        // Get images from storage
        $imagePath = public_path('images/gallery');
        if (is_dir($imagePath)) {
            $imageFiles = glob($imagePath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            foreach ($imageFiles as $file) {
                $filename = basename($file);
                $images[] = [
                    'name' => $filename,
                    'path' => 'images/gallery/' . $filename,
                    'size' => filesize($file),
                    'modified' => filemtime($file),
                    'type' => pathinfo($file, PATHINFO_EXTENSION)
                ];
            }
        }

        // Get video data from database (if exists)
        if (class_exists('App\Models\Video')) {
            $videos = \App\Models\Video::orderBy('created_at', 'desc')->get();
        }

        return view('admin.galeri.index-upgraded', compact('images', 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create-enhanced');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|in:kajian,ramadhan,idul-fitri,idul-adha,pengajian,sosial,bangunan,lainnya',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        // Handle image upload
        $file = $request->file('gambar');
        $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
        
        // Create gallery directory if not exists
        $galleryPath = public_path('images/gallery');
        if (!is_dir($galleryPath)) {
            mkdir($galleryPath, 0755, true);
        }
        
        $file->move($galleryPath, $filename);
        
        // Save to database using Gallery model
        $gallery = new \App\Models\Gallery();
        $gallery->gambar = $filename;
        $gallery->judul = $validated['judul'];
        $gallery->kategori = $validated['kategori'];
        $gallery->deskripsi = $validated['deskripsi'] ?? null;
        $gallery->save();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Implementation for showing specific gallery item
        return view('admin.gallery.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Implementation for editing gallery item
        return view('admin.gallery.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Implementation for updating gallery item
        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Item galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:image,video',
            'filename' => 'required|string',
        ]);

        if ($validated['type'] === 'image') {
            $filePath = public_path('images/gallery/' . $validated['filename']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        } elseif ($validated['type'] === 'video') {
            // Delete from database if Video model exists
            if (class_exists('App\Models\Video')) {
                $video = \App\Models\Video::where('video_id', $validated['filename'])->first();
                if ($video) {
                    if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                        Storage::disk('public')->delete($video->thumbnail);
                    }
                    $video->delete();
                }
            }
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Item galeri berhasil dihapus.');
    }

    /**
     * Bulk delete gallery items
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.type' => 'required|in:image,video',
            'items.*.filename' => 'required|string',
        ]);

        foreach ($validated['items'] as $item) {
            if ($item['type'] === 'image') {
                $filePath = public_path('images/gallery/' . $item['filename']);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } elseif ($item['type'] === 'video') {
                if (class_exists('App\Models\Video')) {
                    $video = \App\Models\Video::where('video_id', $item['filename'])->first();
                    if ($video) {
                        if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                            Storage::disk('public')->delete($video->thumbnail);
                        }
                        $video->delete();
                    }
                }
            }
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', count($validated['items']) . ' item galeri berhasil dihapus.');
    }

    /**
     * Upload multiple images
     */
    public function bulkUpload(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string|max:500',
        ]);

        $uploadedCount = 0;
        $galleryPath = public_path('images/gallery');
        
        if (!is_dir($galleryPath)) {
            mkdir($galleryPath, 0755, true);
        }

        foreach ($validated['images'] as $index => $image) {
            $filename = time() . '_' . $index . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $image->move($galleryPath, $filename);
            $uploadedCount++;
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', $uploadedCount . ' gambar berhasil diunggah ke galeri.');
    }
}
