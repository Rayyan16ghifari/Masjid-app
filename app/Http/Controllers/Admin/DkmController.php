<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DkmController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dkmMembers = Dkm::orderByRaw('CASE 
            WHEN jabatan = "Ketua" THEN 1
            WHEN jabatan = "Wakil Ketua" THEN 2
            WHEN jabatan = "Sekretaris" THEN 3
            WHEN jabatan = "Bendahara" THEN 4
            ELSE 5
        END')->orderBy('nama')->paginate(12);

        return view('admin.dkm.index-simple', compact('dkmMembers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dkm.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'periode' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dkm-photos', $filename, 'public');
            $validated['foto'] = $path;
        }

        Dkm::create($validated);

        return redirect()
            ->route('admin.dkm.index')
            ->with('success', 'Anggota DKM berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dkm $dkm)
    {
        return view('admin.dkm.show', compact('dkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dkm $dkm)
    {
        return view('admin.dkm.edit', compact('dkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dkm $dkm)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'periode' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($dkm->foto && Storage::disk('public')->exists($dkm->foto)) {
                Storage::disk('public')->delete($dkm->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($validated['nama']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dkm-photos', $filename, 'public');
            $validated['foto'] = $path;
        }

        $dkm->update($validated);

        return redirect()
            ->route('admin.dkm.index')
            ->with('success', 'Data anggota DKM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dkm $dkm)
    {
        // Delete photo if exists
        if ($dkm->foto && Storage::disk('public')->exists($dkm->foto)) {
            Storage::disk('public')->delete($dkm->foto);
        }

        $dkm->delete();

        return redirect()
            ->route('admin.dkm.index')
            ->with('success', 'Anggota DKM berhasil dihapus.');
    }

    /**
     * Bulk delete DKM members
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:dkms,id',
        ]);

        $dkmMembers = Dkm::whereIn('id', $validated['ids'])->get();

        foreach ($dkmMembers as $dkm) {
            if ($dkm->foto && Storage::disk('public')->exists($dkm->foto)) {
                Storage::disk('public')->delete($dkm->foto);
            }
            $dkm->delete();
        }

        return redirect()
            ->route('admin.dkm.index')
            ->with('success', count($validated['ids']) . ' anggota DKM berhasil dihapus.');
    }

    /**
     * Search DKM members
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $dkmMembers = Dkm::where('nama', 'like', "%{$query}%")
            ->orWhere('jabatan', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orderByRaw('CASE 
                WHEN jabatan = "Ketua" THEN 1
                WHEN jabatan = "Wakil Ketua" THEN 2
                WHEN jabatan = "Sekretaris" THEN 3
                WHEN jabatan = "Bendahara" THEN 4
                ELSE 5
            END')->orderBy('nama')
            ->paginate(12);

        return view('admin.dkm.index', compact('dkmMembers', 'query'));
    }
}
