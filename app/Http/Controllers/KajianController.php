<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Ustadz;
use App\Models\Kitab;
use App\Models\Rating;
use App\Models\Video;
use App\Models\Dkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KajianController extends Controller
{
    /* ================= DASHBOARD ================= */
    public function dashboard()
    {
        // Kajian terbaru
        $kajianTerbaru = Kajian::with(['ustadz','kitab'])
            ->withAvg('ratings', 'rating')
            ->latest()
            ->take(6)
            ->get();

        // Kajian trending
        $kajianTrending = Kajian::with(['ustadz','kitab'])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(6)
            ->get();

        // Video kajian
        $videos = Video::latest()
            ->take(6)
            ->get();

        // ✅ DKM (FIX)
        $dkm = Dkm::latest()->take(6)->get();

        return view('dashboard', compact(
            'kajianTerbaru',
            'kajianTrending',
            'videos',
            'dkm' // ✅ WAJIB ADA
        ));
    }

    /* ================= CRUD KAJIAN ================= */

    public function index()
    {
        $kajian = Kajian::with(['ustadz','kitab'])
            ->withAvg('ratings', 'rating')
            ->get();

        return view('kajian.index', compact('kajian'));
    }

    public function create()
    {
        $ustadz = Ustadz::all();
        $kitab = Kitab::all();

        return view('kajian.create', compact('ustadz','kitab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'ustadz_id' => 'required',
            'kitab_id' => 'required'
        ]);

        Kajian::create($request->all());

        return redirect('/kajian')->with('success', 'Kajian berhasil ditambahkan');
    }

    public function edit(Kajian $kajian)
    {
        $ustadz = Ustadz::all();
        $kitab = Kitab::all();

        return view('kajian.edit', compact('kajian','ustadz','kitab'));
    }

    public function update(Request $request, Kajian $kajian)
    {
        $request->validate([
            'judul' => 'required',
            'ustadz_id' => 'required',
            'kitab_id' => 'required'
        ]);

        $kajian->update($request->all());

        return redirect('/kajian')->with('success', 'Kajian berhasil diupdate');
    }

    public function destroy(Kajian $kajian)
    {
        $kajian->delete();

        return redirect('/kajian')->with('success', 'Kajian berhasil dihapus');
    }

    /* ================= RATING ================= */

    public function rating(Request $request)
    {
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'kajian_id' => $request->kajian_id
            ],
            [
                'rating' => $request->rating
            ]
        );

        return response()->json(['success' => true]);
    }

    /* ================= SEARCH ================= */

    public function search(Request $request)
    {
        $q = $request->q;

        $kajian = Kajian::with(['ustadz','kitab'])
            ->withAvg('ratings', 'rating')
            ->where('judul','like',"%$q%")
            ->orWhereHas('ustadz', function($query) use ($q){
                $query->where('nama','like',"%$q%");
            })
            ->get();

        return response()->json($kajian);
    }

    /* ================= REKOMENDASI ================= */

    public function rekomendasi()
    {
        $userId = Auth::id();

        $ratings = Rating::with('kajian.ustadz','kajian.kitab')->get();

        $userVector = $ratings
            ->where('user_id',$userId)
            ->pluck('rating','kajian_id');

        $similarity = [];

        foreach ($ratings->groupBy('user_id') as $otherUserId => $items) {

            if ($otherUserId == $userId) continue;

            $otherVector = $items->pluck('rating','kajian_id');

            $dot = 0;
            $normA = 0;
            $normB = 0;

            foreach ($userVector as $k => $v) {
                $dot += $v * ($otherVector[$k] ?? 0);
                $normA += $v * $v;
            }

            foreach ($otherVector as $v) {
                $normB += $v * $v;
            }

            if ($normA > 0 && $normB > 0) {
                $similarity[$otherUserId] = $dot / (sqrt($normA) * sqrt($normB));
            }
        }

        arsort($similarity);

        $recommended = collect();

        foreach ($similarity as $otherUserId => $score) {
            foreach ($ratings->where('user_id',$otherUserId) as $r) {

                if (
                    !$userVector->has($r->kajian_id) &&
                    $r->rating >= 3
                ) {
                    $recommended->push($r->kajian);
                }
            }
        }

        $recommended = $recommended->unique('id');

        return view('kajian.rekomendasi', compact('recommended'));
    }

    /* ================= DKM ================= */

    public function dkm()
    {
        $dkm = Dkm::all();
        return view('dkm.index', compact('dkm'));
    }

    public function dkmDetail($id)
    {
        $d = Dkm::findOrFail($id);
        return view('dkm.show', compact('d'));
    }
}
