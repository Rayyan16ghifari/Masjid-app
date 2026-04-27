<?php

namespace App\Http\Controllers;

use App\Models\Kitab;
use Illuminate\Http\Request;

class KitabController extends Controller
{
    /**
     * Display a listing of kitabs
     */
    public function index()
    {
        $featuredKitabs = Kitab::active()->featured()->latest()->take(3)->get();
        $allKitabs = Kitab::active()->latest()->paginate(12);
        
        return view('kitab.index', compact('featuredKitabs', 'allKitabs'));
    }

    /**
     * Display the specified kitab with PDF viewer
     */
    public function show($id)
    {
        $kitab = Kitab::active()->findOrFail($id);
        
        // Increment views
        $kitab->incrementViews();
        
        // Get related kitabs
        $relatedKitabs = Kitab::active()
            ->where('id', '!=', $kitab->id)
            ->where('kategori', $kitab->kategori)
            ->take(4)
            ->get();
        
        return view('kitab.show', compact('kitab', 'relatedKitabs'));
    }

    /**
     * Search kitabs
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $allKitabs = Kitab::active()
            ->where(function($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                  ->orWhere('judul', 'like', "%{$query}%")
                  ->orWhere('penulis', 'like', "%{$query}%")
                  ->orWhere('deskripsi', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        $allKitabs->appends($request->query());

        return view('kitab.index', [
            'featuredKitabs' => collect(),
            'allKitabs' => $allKitabs,
            'query' => $query,
        ]);
    }

    /**
     * Filter by category
     */
    public function kategori($kategori)
    {
        $allKitabs = Kitab::active()
            ->byKategori($kategori)
            ->latest()
            ->paginate(12);

        return view('kitab.index', [
            'featuredKitabs' => collect(),
            'allKitabs' => $allKitabs,
            'kategori' => $kategori,
        ]);
    }

    /**
     * API endpoint for PDF download/view
     */
    public function viewPdf($id)
    {
        $kitab = Kitab::active()->findOrFail($id);
        
        $pdfPath = $kitab->resolvePublicAssetAbsolutePath($kitab->pdf_path);
        
        if (!$pdfPath || !file_exists($pdfPath)) {
            abort(404, 'PDF file not found');
        }
        
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $kitab->nama . '.pdf"'
        ]);
    }

    /**
     * API endpoint for PDF download
     */
    public function downloadPdf($id)
    {
        $kitab = Kitab::active()->findOrFail($id);
        
        $pdfPath = $kitab->resolvePublicAssetAbsolutePath($kitab->pdf_path);
        
        if (!$pdfPath || !file_exists($pdfPath)) {
            abort(404, 'PDF file not found');
        }
        
        return response()->download($pdfPath, $kitab->nama . '.pdf');
    }
}
