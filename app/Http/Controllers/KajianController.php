<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Ustadz;
use App\Models\Kitab;
use App\Models\Rating;
use App\Models\Video;
use App\Models\Dkm;
use App\Models\Pengumuman;
use App\Models\Donasi;
use App\Models\User;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class KajianController extends Controller
{
    /* ================= DASHBOARD ================= */
    public function dashboard()
    {
        // =========================
        // KAJIAN TERBARU
        // =========================
        $kajianTerbaru = Kajian::with(['ustadz','kitab'])
            ->withAvg('ratings', 'rating')
            ->latest()
            ->take(6)
            ->get();

        // =========================
        // KAJIAN TRENDING
        // =========================
        $kajianTrending = Kajian::with(['ustadz','kitab'])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->take(6)
            ->get();

        // =========================
        // VIDEO KAJIAN
        // =========================
        $videos = Video::latest()
            ->take(6)
            ->get();

        // =========================
        // ADMIN STATISTICS
        // =========================
        $totalJamaah = User::count();
        $totalKajian = Kajian::count();
        $totalRating = Rating::count();
        $totalDonasi = Donasi::sum('nominal');
        $totalTransaksiDonasi = Donasi::count();

        // =========================
        // DATA DKM
        // =========================
        $totalDkm = Dkm::count();

        $dkm = Dkm::latest()
            ->take(6)
            ->get();

        // =========================
        // JADWAL SHOLAT
        // =========================
        $jadwal = null;

        try {
            $response = Http::get("http://api.aladhan.com/v1/timingsByCity", [
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'method' => 11
            ]);

            if ($response->successful()) {
                $jadwal = $response['data']['timings'];
            }
        } catch (\Exception $e) {
            $jadwal = null;
        }

        // =========================
        // PENGUMUMAN (FIX)
        // =========================
        $pengumuman = Pengumuman::latest()
            ->take(3)
            ->get();

        // =========================
        // RETURN VIEW (FIX DI SINI)
        // =========================
        return view('dashboard', compact(
            'kajianTerbaru',
            'kajianTrending',
            'videos',
            'dkm',
            'totalDkm',
            'totalJamaah',
            'totalKajian',
            'totalRating',
            'totalDonasi',
            'totalTransaksiDonasi',
            'jadwal',
            'pengumuman' // 🔥 WAJIB ADA
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
        $kategoriOptions = $this->kajianCategoryOptions();

        return view('kajian.create', compact('ustadz','kitab', 'kategoriOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => ['required', Rule::in($this->kajianCategoryOptions())],
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
        $kategoriOptions = $this->kajianCategoryOptions();

        return view('kajian.edit', compact('kajian','ustadz','kitab', 'kategoriOptions'));
    }

    public function update(Request $request, Kajian $kajian)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => ['required', Rule::in($this->kajianCategoryOptions())],
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
        $allKajian = Kajian::with(['ustadz', 'kitab'])
            ->withAvg('ratings', 'rating')
            ->get()
            ->keyBy('id');

        $userRatings = Rating::with('kajian.kitab')
            ->where('user_id', $userId)
            ->get();

        $ratedKajianIds = $userRatings
            ->pluck('kajian_id')
            ->flip();

        $preferredCategories = [];

        foreach ($userRatings->where('rating', '>=', 3) as $rating) {
            $kategori = $this->resolveKajianKategori($rating->kajian);
            $preferredCategories[$kategori] = ($preferredCategories[$kategori] ?? 0) + max(((int) $rating->rating) - 2, 1);
        }

        arsort($preferredCategories);

        $allRatings = Rating::with(['kajian.ustadz', 'kajian.kitab'])
            ->get();

        $userVector = $allRatings
            ->where('user_id', $userId)
            ->pluck('rating', 'kajian_id');

        $similarity = [];

        foreach ($allRatings->groupBy('user_id') as $otherUserId => $items) {
            if ((int) $otherUserId === (int) $userId) {
                continue;
            }

            $otherVector = $items->pluck('rating', 'kajian_id');
            $commonKeys = array_intersect(array_keys($userVector->all()), array_keys($otherVector->all()));

            if (count($commonKeys) === 0) {
                continue;
            }

            $dot = 0;
            $normA = 0;
            $normB = 0;

            foreach ($commonKeys as $key) {
                $a = (int) $userVector[$key];
                $b = (int) $otherVector[$key];
                $dot += $a * $b;
                $normA += $a * $a;
                $normB += $b * $b;
            }

            if ($normA > 0 && $normB > 0) {
                $score = $dot / (sqrt($normA) * sqrt($normB));

                if ($score > 0) {
                    $similarity[$otherUserId] = $score;
                }
            }
        }

        arsort($similarity);

        $collaborativeRaw = [];
        $collaborativeSupport = [];

        foreach ($similarity as $otherUserId => $score) {
            foreach ($allRatings->where('user_id', $otherUserId)->where('rating', '>=', 3) as $rating) {
                if ($ratedKajianIds->has($rating->kajian_id)) {
                    continue;
                }

                $collaborativeRaw[$rating->kajian_id] = ($collaborativeRaw[$rating->kajian_id] ?? 0) + ($score * (int) $rating->rating);
                $collaborativeSupport[$rating->kajian_id] = ($collaborativeSupport[$rating->kajian_id] ?? 0) + 1;
            }
        }

        $contentRaw = [];

        foreach ($allKajian as $kajianId => $kajian) {
            if ($ratedKajianIds->has($kajianId)) {
                continue;
            }

            $kategori = $this->resolveKajianKategori($kajian);
            $contentRaw[$kajianId] = $preferredCategories[$kategori] ?? 0;
        }

        $collaborativeScores = $this->normalizeScoreMap($collaborativeRaw);
        $contentScores = $this->normalizeScoreMap(array_filter($contentRaw, fn ($score) => $score > 0));

        $candidateIds = collect(array_unique(array_merge(
            array_keys($collaborativeScores),
            array_keys($contentScores)
        )));

        $recommended = $candidateIds
            ->map(function ($kajianId) use ($allKajian, $collaborativeScores, $contentScores, $collaborativeSupport, $preferredCategories) {
                $kajian = $allKajian->get($kajianId);

                if (!$kajian) {
                    return null;
                }

                $kategori = $this->resolveKajianKategori($kajian);
                $collaborativeScore = $collaborativeScores[$kajianId] ?? 0;
                $contentScore = $contentScores[$kajianId] ?? 0;
                $popularityBoost = min(((float) ($kajian->ratings_avg_rating ?? 0)) / 5, 1) * 0.1;
                $hybridScore = ($collaborativeScore * 0.55) + ($contentScore * 0.35) + $popularityBoost;

                $source = 'Hybrid AI';
                $reason = 'Kajian ini dipilih dari kombinasi selera kategori dan pola rating jamaah yang mirip denganmu.';

                if ($contentScore > 0 && $collaborativeScore <= 0) {
                    $source = 'Content-Based';
                    $reason = 'Karena kamu suka ' . strtolower($kategori) . ', sistem memprioritaskan kajian dari kategori yang sama.';
                } elseif ($contentScore <= 0 && $collaborativeScore > 0) {
                    $source = 'Collaborative Filtering';
                    $reason = 'Jamaah dengan pola rating yang mirip memberikan nilai baik pada kajian ini.';
                } elseif ($contentScore > 0 && $collaborativeScore > 0) {
                    $reason = 'Karena kamu suka ' . strtolower($kategori) . ', lalu preferensi itu diperkuat oleh rating jamaah dengan selera serupa.';
                }

                $kajian->setAttribute('kategori_label', $kategori);
                $kajian->setAttribute('recommendation_source', $source);
                $kajian->setAttribute('recommendation_reason', $reason);
                $kajian->setAttribute('hybrid_score', (int) round($hybridScore * 100));
                $kajian->setAttribute('collaborative_score', (int) round($collaborativeScore * 100));
                $kajian->setAttribute('content_score', (int) round($contentScore * 100));
                $kajian->setAttribute('support_count', $collaborativeSupport[$kajianId] ?? 0);
                $kajian->setAttribute('category_weight', $preferredCategories[$kategori] ?? 0);

                return $kajian;
            })
            ->filter()
            ->sortByDesc('hybrid_score')
            ->take(8)
            ->values();

        $recommendationMode = 'hybrid';

        if ($recommended->isEmpty()) {
            $recommendationMode = 'popular';

            $recommended = $allKajian
                ->reject(fn ($kajian) => $ratedKajianIds->has($kajian->id))
                ->sortByDesc(fn ($kajian) => (float) ($kajian->ratings_avg_rating ?? 0))
                ->take(6)
                ->values()
                ->map(function ($kajian) {
                    $kategori = $this->resolveKajianKategori($kajian);

                    $kajian->setAttribute('kategori_label', $kategori);
                    $kajian->setAttribute('recommendation_source', 'Popular Picks');
                    $kajian->setAttribute('recommendation_reason', 'Belum ada cukup data preferensi, jadi sistem menampilkan kajian populer dengan rating tinggi terlebih dahulu.');
                    $kajian->setAttribute('hybrid_score', (int) round(min(((float) ($kajian->ratings_avg_rating ?? 0)) / 5, 1) * 100));
                    $kajian->setAttribute('collaborative_score', 0);
                    $kajian->setAttribute('content_score', 0);
                    $kajian->setAttribute('support_count', 0);
                    $kajian->setAttribute('category_weight', 0);

                    return $kajian;
                });
        }

        return view('kajian.rekomendasi', [
            'recommended' => $recommended,
            'preferredCategories' => collect($preferredCategories)->take(3),
            'userRatingsCount' => $userRatings->count(),
            'similarUsersCount' => count($similarity),
            'recommendationMode' => $recommendationMode,
        ]);
    }

    /* ================= DKM ================= */

    public function dkm()
    {
        return view('dkm.index', $this->buildDkmViewData());
    }

    public function strukturOrganisasi()
    {
        return view('dkm.index', $this->buildDkmViewData([
            'pageEyebrow' => 'Struktur Organisasi Masjid',
            'pageTitle' => 'Struktur Organisasi DKM Masjid Al-Hasanah',
            'pageSubtitle' => 'Susunan organisasi ditampilkan lebih formal untuk memperjelas garis koordinasi, tingkatan jabatan, dan pembagian tanggung jawab di lingkungan masjid.',
            'pageNoteTitle' => 'Visual organisasi lebih formal',
            'pageNoteCopy' => 'Halaman ini menekankan susunan kepengurusan dari pimpinan utama hingga unit pelayanan, sehingga lebih layak ditampilkan sebagai struktur organisasi resmi.',
        ]));
    }

    public function dkmDetail($id)
    {
        $d = Dkm::findOrFail($id);
        return view('dkm.show', compact('d'));
    }

    public function kontak()
    {
        $contact = $this->masjidContactData();

        return view('kontak.index', compact('contact'));
    }

    public function jadwalKajian()
    {
        $dayOrder = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
            'Minggu' => 7,
        ];

        $jadwalKajian = Kajian::with(['ustadz', 'kitab'])
            ->withAvg('ratings', 'rating')
            ->get()
            ->sortBy(function ($kajian) use ($dayOrder) {
                $dayRank = $dayOrder[$kajian->hari] ?? 99;
                $timeRank = $kajian->waktu ?: '99:99:99';

                return sprintf('%02d-%s-%s', $dayRank, $timeRank, strtolower($kajian->judul ?? ''));
            })
            ->values();

        $jadwalByHari = $jadwalKajian
            ->groupBy('hari')
            ->sortKeysUsing(function ($a, $b) use ($dayOrder) {
                return ($dayOrder[$a] ?? 99) <=> ($dayOrder[$b] ?? 99);
            });

        $kategoriTersedia = $jadwalKajian
            ->map(fn ($kajian) => $this->resolveKajianKategori($kajian))
            ->unique()
            ->values();

        return view('jadwal.index', [
            'jadwalKajian' => $jadwalKajian,
            'jadwalByHari' => $jadwalByHari,
            'kategoriTersedia' => $kategoriTersedia,
        ]);
    }

    public function faq()
    {
        $faqItems = [
            [
                'question' => 'Jam buka masjid bagaimana?',
                'answer' => 'Masjid terbuka setiap hari untuk shalat berjamaah dan kegiatan pembinaan. Untuk layanan administrasi atau koordinasi pengurus, silakan hubungi kontak resmi yang tersedia di halaman kontak.',
            ],
            [
                'question' => 'Di mana saya bisa melihat jadwal kajian?',
                'answer' => 'Jadwal kajian rutin dapat dilihat pada halaman Jadwal Kajian, lengkap dengan hari, ustadz, tema, waktu, dan lokasi pelaksanaan.',
            ],
            [
                'question' => 'Bagaimana cara mendapatkan rekomendasi kajian dari sistem?',
                'answer' => 'Berikan rating pada kajian yang sudah Anda ikuti. Sistem hybrid AI akan memadukan kesamaan rating jamaah lain dan kategori kajian yang Anda sukai.',
            ],
            [
                'question' => 'Apakah donasi saya tercatat di sistem?',
                'answer' => 'Ya. Setiap transaksi donasi akan tercatat dan bisa dipantau kembali melalui halaman Riwayat Donasi setelah proses pembayaran dilakukan.',
            ],
            [
                'question' => 'Siapa yang bisa dihubungi untuk pertanyaan lebih lanjut?',
                'answer' => 'Anda bisa menggunakan informasi resmi pada halaman Kontak atau menghubungi pengurus inti yang tercantum pada halaman Struktur Organisasi.',
            ],
        ];

        return view('faq.index', compact('faqItems'));
    }

    private function buildDkmViewData(array $overrides = []): array
    {
        $sectionMeta = $this->dkmSectionMeta();

        $dkm = Dkm::get()
            ->sortBy(function ($member) {
                $sectionOrder = $this->dkmSectionOrder($member->jabatan);
                $jabatanOrder = $this->dkmJabatanRank($member->jabatan);
                $namaOrder = strtolower($member->nama ?? '');

                return sprintf('%03d-%03d-%s', $sectionOrder, $jabatanOrder, $namaOrder);
            })
            ->values();

        $dkmSections = collect($sectionMeta)
            ->map(function ($meta, $key) use ($dkm) {
                $members = $dkm
                    ->filter(fn ($member) => $this->dkmSectionKey($member->jabatan) === $key)
                    ->values();

                if ($members->isEmpty()) {
                    return null;
                }

                return [
                    'key' => $key,
                    'meta' => $meta,
                    'members' => $members,
                ];
            })
            ->filter()
            ->values();

        $ketuaDkm = $dkm->first(function ($member) {
            return $this->normalizeDkmJabatan($member->jabatan) === 'ketua';
        });

        return array_merge([
            'dkm' => $dkm,
            'dkmSections' => $dkmSections,
            'ketuaDkm' => $ketuaDkm,
            'pageEyebrow' => 'Dewan Kemakmuran Masjid',
            'pageTitle' => 'Struktur Pengurus & Anggota DKM',
            'pageSubtitle' => 'Susunan pengurus kini ditampilkan berdasarkan tingkatan jabatan, sehingga posisi inti seperti Ketua, pengurus harian, layanan ibadah, hingga seksi pendukung lebih mudah dipahami dalam satu alur visual.',
            'pageNoteTitle' => 'Hierarki organisasi lebih jelas',
            'pageNoteCopy' => 'Setiap bagian disusun dari jabatan tertinggi ke lapisan pendukung agar struktur kerja DKM terasa lebih profesional dan mudah dibaca jamaah.',
        ], $overrides);
    }

    private function kajianCategoryOptions(): array
    {
        return [
            'Aqidah',
            'Fiqih',
            'Hadits',
            'Sirah',
            'Tazkiyah',
            'Akhlak',
            'Al-Quran',
            'Muamalah',
            'Dakwah Umum',
        ];
    }

    private function resolveKajianKategori($kajian): string
    {
        if (!$kajian) {
            return 'Dakwah Umum';
        }

        $kategori = trim((string) ($kajian->kategori ?? ''));

        if ($kategori !== '') {
            return $kategori;
        }

        $kitabNama = $kajian->relationLoaded('kitab') ? ($kajian->kitab->nama ?? null) : null;

        return $this->inferKajianKategori(
            $kajian->judul ?? null,
            $kitabNama,
            $kajian->deskripsi ?? null
        );
    }

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

    private function normalizeScoreMap(array $scores): array
    {
        if (empty($scores)) {
            return [];
        }

        $values = array_values($scores);
        $min = min($values);
        $max = max($values);

        if ((float) $max === (float) $min) {
            return array_map(fn ($score) => $score > 0 ? 1 : 0, $scores);
        }

        $normalized = [];

        foreach ($scores as $key => $score) {
            $normalized[$key] = ($score - $min) / ($max - $min);
        }

        return $normalized;
    }

    private function masjidContactData(): array
    {
        $ketua = Dkm::get()
            ->sortBy(function ($member) {
                return sprintf('%03d-%s', $this->dkmJabatanRank($member->jabatan), strtolower($member->nama ?? ''));
            })
            ->first();

        $address = 'Komplek Pushubad Cijantung Jl. Radar VII Kel. Kalisari, Kec. Pasar Rebo, Jakarta Timur 13790';
        $phone = $ketua->no_hp ?? '081234567890';
        $email = $ketua->email ?? 'info@masjidalhasanah.id';

        return [
            'address' => $address,
            'mapsEmbed' => 'https://www.google.com/maps?q=' . urlencode($address) . '&output=embed',
            'whatsapp' => $phone,
            'whatsappLink' => 'https://wa.me/' . $this->normalizeWhatsappNumber($phone),
            'email' => $email,
            'contactName' => $ketua->nama ?? 'Pengurus Masjid',
            'contactRole' => $ketua->jabatan ?? 'Ketua DKM',
        ];
    }

    private function normalizeWhatsappNumber(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone ?? '') ?? '';

        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }

        if (str_starts_with($digits, '62')) {
            return $digits;
        }

        return '62' . $digits;
    }

    private function normalizeDkmJabatan(?string $jabatan): string
    {
        $normalized = strtolower(trim($jabatan ?? ''));

        return preg_replace('/\s+/', ' ', $normalized) ?? '';
    }

    private function dkmJabatanRank(?string $jabatan): int
    {
        $normalized = $this->normalizeDkmJabatan($jabatan);

        return match (true) {
            $normalized === 'ketua' => 10,
            $normalized === 'wakil ketua' => 20,
            in_array($normalized, ['sekretaris', 'sekertaris', 'sekretaris umum'], true) => 30,
            $normalized === 'wakil sekretaris' => 40,
            $normalized === 'bendahara' => 50,
            $normalized === 'wakil bendahara' => 60,
            $normalized === 'imam rawatib' => 70,
            $normalized === 'imam besar' => 80,
            $normalized === 'imam' => 90,
            $normalized === 'khatib' => 100,
            in_array($normalized, ['muadzin', 'muazin'], true) => 110,
            str_starts_with($normalized, 'ketua bidang') => 120,
            str_starts_with($normalized, 'koordinator') => 130,
            str_starts_with($normalized, 'seksi') => 140,
            str_contains($normalized, 'majelis ta') => 150,
            str_contains($normalized, 'tpa') => 160,
            str_contains($normalized, 'zis') => 170,
            str_contains($normalized, 'jenazah') => 180,
            $normalized === 'anggota' => 190,
            default => 900,
        };
    }

    private function dkmSectionKey(?string $jabatan): string
    {
        $rank = $this->dkmJabatanRank($jabatan);

        return match (true) {
            $rank <= 20 => 'pimpinan',
            $rank <= 60 => 'harian',
            $rank <= 110 => 'ibadah',
            $rank <= 190 => 'seksi',
            default => 'anggota',
        };
    }

    private function dkmSectionOrder(?string $jabatan): int
    {
        return match ($this->dkmSectionKey($jabatan)) {
            'pimpinan' => 1,
            'harian' => 2,
            'ibadah' => 3,
            'seksi' => 4,
            default => 5,
        };
    }

    private function dkmSectionMeta(): array
    {
        return [
            'pimpinan' => [
                'level' => 'Tingkatan 1',
                'title' => 'Pimpinan Utama',
                'description' => 'Lapisan tertinggi yang memegang arah kebijakan, keputusan utama, dan koordinasi besar organisasi.',
                'ribbon' => 'Inti',
                'accent' => 'gold',
            ],
            'harian' => [
                'level' => 'Tingkatan 2',
                'title' => 'Pengurus Harian',
                'description' => 'Posisi inti yang memastikan administrasi, keuangan, dan operasional DKM berjalan dengan rapi.',
                'ribbon' => 'Harian',
                'accent' => 'emerald',
            ],
            'ibadah' => [
                'level' => 'Tingkatan 3',
                'title' => 'Pelayanan Ibadah',
                'description' => 'Jabatan yang berfokus pada imam, khatib, dan dukungan pelaksanaan ibadah jamaah.',
                'ribbon' => 'Ibadah',
                'accent' => 'teal',
            ],
            'seksi' => [
                'level' => 'Tingkatan 4',
                'title' => 'Seksi & Bidang Pelayanan',
                'description' => 'Bidang teknis yang menangani program, pelayanan jamaah, dan kegiatan kemasjidan sehari-hari.',
                'ribbon' => 'Seksi',
                'accent' => 'mint',
            ],
            'anggota' => [
                'level' => 'Tingkatan 5',
                'title' => 'Anggota Pendukung',
                'description' => 'Anggota pelaksana yang memperkuat kelancaran kegiatan, pelayanan, dan dukungan organisasi.',
                'ribbon' => 'Anggota',
                'accent' => 'slate',
            ],
        ];
    }

    /* ================= PENGUMUMAN ================= */

    public function pengumuman()
    {
        $pengumuman = Pengumuman::latest()->get();
        return view('pengumuman.index', compact('pengumuman'));
    }

    /* ================= TENTANG ================= */

    public function tentang()
    {
        return view('tentang.index');
    }

    public function donasi()
    {
        return view('donasi.index');
    }

    public function donasiStore(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
            'jenis' => 'required'
        ]);

        // =========================
        // SIMPAN KE DB
        // =========================
        $donasi = Donasi::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'jenis' => $request->jenis,
            'status' => 'pending',
            'metode' => 'midtrans'
        ]);

        // =========================
        // CONFIG MIDTRANS
        // =========================
        Config::$serverKey = 'YOUR_SERVER_KEY';
        Config::$isProduction = false; // sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // =========================
        // DATA TRANSAKSI
        // =========================
        $params = [
            'transaction_details' => [
                'order_id' => 'DONASI-'.$donasi->id.'-'.time(),
                'gross_amount' => $donasi->nominal,
            ],
            'customer_details' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        // =========================
        // SNAP TOKEN
        // =========================
        $snapToken = Snap::getSnapToken($params);

        // =========================
        // RETURN KE VIEW
        // =========================
        return view('donasi.payment', compact('snapToken'));
    }

    public function donasiHistory()
    {
        $donasi = Donasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('donasi.history', compact('donasi'));
    }
}
