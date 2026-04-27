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
use App\Models\Kas;
use App\Models\Koordinator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class KajianController extends Controller
{
    private const PRAYER_TIMEZONE = 'Asia/Jakarta';
    private const PRAYER_METHOD = 20;
    private const PRAYER_SCHOOL = 0;

    /* ================= DASHBOARD ================= */
    public function dashboard()
    {
        // =========================
        // WAKTU SHOLAT
        // =========================
        $today = $this->prayerNow();
        $location = $this->prayerLocation();
        $latitude = $location['latitude'];
        $longitude = $location['longitude'];
        
        $prayerTimes = $this->calculatePrayerTimes($today, $latitude, $longitude);
        $currentPrayer = $this->getCurrentPrayer($prayerTimes);
        $nextPrayer = $this->getNextPrayer($prayerTimes);

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
        $videos = \App\Models\Video::latest()
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
        // RETURN VIEW (USER DASHBOARD)
        // =========================
        return view('dashboard', compact(
            'prayerTimes',
            'currentPrayer',
            'nextPrayer',
            'today',
            'kajianTerbaru',
            'kajianTrending',
            'videos',
            'totalJamaah',
            'totalKajian',
            'totalRating',
            'totalDonasi',
            'totalTransaksiDonasi',
            'totalDkm',
            'dkm',
            'jadwal',
            'pengumuman'
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
        $cfService = new \App\Services\CollaborativeFilteringService();
        
        try {
            // Dapatkan rekomendasi menggunakan hybrid CF
            $recommendationIds = $cfService->getHybridRecommendations($userId, 10);
            
            // Load data kajian yang direkomendasikan
            $recommended = Kajian::with(['ustadz', 'kitab'])
                ->withAvg('ratings', 'rating')
                ->withCount('ratings')
                ->whereIn('id', array_keys($recommendationIds))
                ->get()
                ->map(function ($kajian) use ($recommendationIds) {
                    $kajian->predicted_rating = round($recommendationIds[$kajian->id] ?? 0, 2);
                    $kajian->kategori = $this->resolveKajianKategori($kajian);
                    return $kajian;
                })
                ->sortByDesc('predicted_rating')
                ->values();

            // Dapatkan preferensi kategori user
            $userRatings = Rating::with('kajian.kitab')
                ->where('user_id', $userId)
                ->get();

            $preferredCategories = [];
            foreach ($userRatings->where('rating', '>=', 3) as $rating) {
                $kategori = $this->resolveKajianKategori($rating->kajian);
                $preferredCategories[$kategori] = ($preferredCategories[$kategori] ?? 0) + max(((int) $rating->rating) - 2, 1);
            }
            arsort($preferredCategories);

            // Evaluasi sistem (untuk development/testing)
            $evaluation = $cfService->evaluateRecommendations($userId);

            // Hitung jumlah similar users dari evaluation atau dari service
            $similarUsersCount = isset($evaluation['similar_users']) ? $evaluation['similar_users'] : 0;
            
            return view('kajian.rekomendasi', [
                'recommended' => $recommended,
                'preferredCategories' => collect($preferredCategories)->take(3),
                'userRatingsCount' => $userRatings->count(),
                'similarUsersCount' => $similarUsersCount,
                'evaluation' => $evaluation,
                'algorithm' => 'Hybrid Collaborative Filtering (User-Based + Item-Based)',
                'recommendationMode' => 'hybrid',
            ]);
            
        } catch (\Exception $e) {
            // Fallback ke rekomendasi populer jika terjadi error
            return $this->getPopularRecommendations($userId);
        }
    }

    private function getPopularRecommendations($userId)
    {
        $userRatings = Rating::where('user_id', $userId)->pluck('kajian_id');
        
        $recommended = Kajian::with(['ustadz', 'kitab'])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->whereNotIn('id', $userRatings)
            ->having('ratings_count', '>=', 3)
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->limit(10)
            ->get()
            ->map(function ($kajian) {
                $kajian->predicted_rating = $kajian->ratings_avg_rating ?? 0;
                $kajian->kategori = $this->resolveKajianKategori($kajian);
                return $kajian;
            });

        return view('kajian.rekomendasi', [
            'recommended' => $recommended,
            'preferredCategories' => collect([]),
            'userRatingsCount' => $userRatings->count(),
            'similarUsersCount' => 0,
            'evaluation' => ['rmse' => 0, 'mae' => 0, 'coverage' => 0],
            'algorithm' => 'Popular-based (Fallback)',
            'recommendationMode' => 'popular',
        ]);
    }

    /* ================= DKM ================= */

    public function dkm()
    {
        return view('dkm.index', $this->buildDkmViewData());
    }

    public function strukturOrganisasi()
    {
        return redirect()->route('dkm.index');
    }

    public function dkmDetail($id)
    {
        $d = Dkm::findOrFail($id);
        return view('dkm.show', compact('d'));
    }

    // ================= CREATE =================
    public function dkmCreate()
    {
        return view('dkm.create', $this->dkmFormViewData());
    }

    // ================= STORE =================
    public function dkmStore(Request $request)
    {
        $payload = $this->sanitizeDkmPayload(
            $request->validate($this->dkmValidationRules())
        );

        $member = Dkm::create($payload);

        return redirect()
            ->route('dkm.show', $member->id)
            ->with('success', 'Data anggota DKM berhasil ditambahkan.');
    }

    // ================= EDIT =================
    public function dkmEdit($id)
    {
        $d = Dkm::findOrFail($id);

        return view('dkm.edit', array_merge(
            ['d' => $d],
            $this->dkmFormViewData()
        ));
    }

    // ================= UPDATE =================
    public function dkmUpdate(Request $request, $id)
    {
        $d = Dkm::findOrFail($id);

        $payload = $this->sanitizeDkmPayload(
            $request->validate($this->dkmValidationRules())
        );

        $d->update($payload);

        return redirect()
            ->route('dkm.show', $d->id)
            ->with('success', 'Data anggota DKM berhasil diperbarui.');
    }

    // ================= DELETE =================
    public function dkmDestroy($id)
    {
        $d = Dkm::findOrFail($id);
        $d->delete();

        return redirect()
            ->route('dkm.index')
            ->with('success', 'Data anggota DKM berhasil dihapus.');
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

    public function galeri()
    {
        // Fetch real gallery data from database
        $galleries = \App\Models\Gallery::latest()->get();
        
        // Convert to the format expected by the view
        $galleryPhotos = [];
        
        foreach ($galleries as $gallery) {
            $galleryPhotos[] = [
                'src' => 'images/gallery/' . $gallery->gambar,
                'title' => $gallery->judul,
                'date' => $gallery->created_at->format('Y-m-d'),
                'category' => ucfirst($gallery->kategori)
            ];
        }
        
        // If no gallery data, provide fallback
        if (empty($galleryPhotos)) {
            $galleryPhotos = [
                [
                    'src' => 'images/masjid/Masjid1.jpg',
                    'title' => 'Masjid Al-Hasanah - Tampak Depan',
                    'date' => '2026-04-15',
                    'category' => 'Bangunan'
                ],
                [
                    'src' => 'images/masjid/Masjid2.jpg',
                    'title' => 'Halaman Luar Masjid',
                    'date' => '2026-04-10',
                    'category' => 'Area Masjid'
                ],
            ];
        }

        // Group photos by month for better organization
        $groupedPhotos = collect($galleryPhotos)->groupBy(function ($photo) {
            return date('F Y', strtotime($photo['date']));
        });

        return view('galeri.index', compact('galleryPhotos', 'groupedPhotos'));
    }

    public function waktuSholat()
    {
        // Get current date and location (East Jakarta)
        $today = $this->prayerNow();
        $location = $this->prayerLocation();
        $latitude = $location['latitude'];
        $longitude = $location['longitude'];
        
        // Calculate prayer times (simplified calculation for demo)
        $prayerTimes = $this->calculatePrayerTimes($today, $latitude, $longitude);
        
        // Get current prayer
        $currentPrayer = $this->getCurrentPrayer($prayerTimes);
        
        // Get next prayer
        $nextPrayer = $this->getNextPrayer($prayerTimes);
        
        return view('waktu-sholat.index', compact(
            'prayerTimes', 
            'currentPrayer', 
            'nextPrayer', 
            'today'
        ));
    }

    private function calculatePrayerTimes($date, $latitude, $longitude)
    {
        $date = $date->copy()->timezone(self::PRAYER_TIMEZONE);

        $timings = $this->fetchPrayerTimingsByCoordinates($date, $latitude, $longitude)
            ?? $this->fetchPrayerTimingsByAddress($date);

        if (is_array($timings)) {
            return $this->buildPrayerTimes($timings);
        }

        return $this->fallbackPrayerTimes($date);

        // Try to get real prayer times from API with proper Jakarta timezone
        try {
            // Use coordinates for Jakarta and proper method
            $response = Http::get("http://api.aladhan.com/v1/timings", [
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'method' => 2, // Muslim World League
                'adjustments' => '1', // Adjust for Jakarta timezone (GMT+7)
                'school' => 0 // Shafi'i (standard for Indonesia)
            ]);

            if ($response->successful()) {
                $timings = $response['data']['timings'];
                
                // Convert 24-hour format to ensure proper display
                $convertTime = function($time) {
                    return date('H:i', strtotime($time));
                };
                
                // Only return 5 prayer times like Istiqlal website with proper icons
                return [
                    'subuh' => [
                        'name' => 'Subuh',
                        'time' => $convertTime($timings['Fajr']),
                        'icon' => '🌅',
                        'description' => 'Waktu sholat Subuh'
                    ],
                    'dzuhur' => [
                        'name' => 'Dzuhur',
                        'time' => $convertTime($timings['Dhuhr']),
                        'icon' => '☀️',
                        'description' => 'Waktu sholat Dzuhur'
                    ],
                    'ashar' => [
                        'name' => 'Ashar',
                        'time' => $convertTime($timings['Asr']),
                        'icon' => '�️',
                        'description' => 'Waktu sholat Ashar'
                    ],
                    'magrib' => [
                        'name' => 'Magrib',
                        'time' => $convertTime($timings['Maghrib']),
                        'icon' => '🌆',
                        'description' => 'Waktu sholat Magrib'
                    ],
                    'isya' => [
                        'name' => 'Isya',
                        'time' => $convertTime($timings['Isha']),
                        'icon' => '🌙',
                        'description' => 'Waktu sholat Isya'
                    ]
                ];
            }
        } catch (\Exception $e) {
            // Fallback to calculation if API fails
        }

        // Fallback calculation - accurate Jakarta prayer times for today
        // Based on typical Jakarta prayer times for current date
        $currentHour = now()->hour;
        
        // Use realistic Jakarta prayer times
        $times = [
            'subuh' => '04:24',
            'dzuhur' => '11:47', 
            'ashar' => '15:02',
            'magrib' => '17:51',
            'isya' => '19:02'
        ];

        return [
            'subuh' => [
                'name' => 'Subuh',
                'time' => $times['subuh'],
                'icon' => '�',
                'description' => 'Waktu sholat Subuh'
            ],
            'dzuhur' => [
                'name' => 'Dzuhur',
                'time' => $times['dzuhur'],
                'icon' => '☀️',
                'description' => 'Waktu sholat Dzuhur'
            ],
            'ashar' => [
                'name' => 'Ashar',
                'time' => $times['ashar'],
                'icon' => '�️',
                'description' => 'Waktu sholat Ashar'
            ],
            'magrib' => [
                'name' => 'Magrib',
                'time' => $times['magrib'],
                'icon' => '🌆',
                'description' => 'Waktu sholat Magrib'
            ],
            'isya' => [
                'name' => 'Isya',
                'time' => $times['isya'],
                'icon' => '🌙',
                'description' => 'Waktu sholat Isya'
            ]
        ];
    }

    private function calculateDhuhaTime($sunriseTime)
    {
        // Dhuha is typically 20-45 minutes after sunrise
        $sunrise = \Carbon\Carbon::createFromFormat('H:i', $sunriseTime);
        return $sunrise->addMinutes(30)->format('H:i');
    }

    private function timeFromAngle($date, $angle, $latitude, $longitude, $isSunset = false)
    {
        // Simplified calculation - in production use proper astronomical calculations
        $baseTime = $isSunset ? '18:00' : '04:30';
        
        // Adjust based on prayer type
        $adjustments = [
            'imsak' => '-10 minutes',
            'subuh' => '0 minutes',
            'terbit' => '+20 minutes',
            'dhuha' => '+45 minutes',
            'dzuhur' => '+6 hours 30 minutes',
            'ashar' => '+8 hours 15 minutes',
            'magrib' => '+6 hours 15 minutes',
            'isya' => '+7 hours 30 minutes'
        ];

        $baseDateTime = $date->copy()->setTimeFromTimeString($baseTime);
        
        // Apply adjustments based on prayer type
        if ($angle === -18) return $baseDateTime->format('H:i');
        if ($angle === -0.8333 && !$isSunset) return $baseDateTime->addMinutes(20)->format('H:i');
        if ($angle === 10) return $baseDateTime->addMinutes(45)->format('H:i');
        if ($angle === -17 && $isSunset) return $baseDateTime->addHours(7)->addMinutes(30)->format('H:i');
        
        return $baseDateTime->format('H:i');
    }

    private function calculateDzuhurTime($date, $longitude)
    {
        // Dzuhur is when the sun is at its highest point
        $noon = $date->copy()->setTime(12, 0);
        // Adjust for longitude (Jakarta is GMT+7)
        $adjustment = ($longitude / 15) * 60; // Convert longitude to time
        return $noon->addMinutes($adjustment + 30)->format('H:i');
    }

    private function calculateAsharTime($date, $latitude, $longitude)
    {
        // Ashar is typically 1.5 to 2 shadow lengths
        $dzuhurTime = $this->calculateDzuhurTime($date, $longitude);
        $dzuhurDateTime = $date->copy()->setTimeFromTimeString($dzuhurTime);
        return $dzuhurDateTime->addHours(2)->addMinutes(15)->format('H:i');
    }

    private function getCurrentPrayer($prayerTimes)
    {
        $now = $this->prayerNow()->format('H:i');
        $current = null;
        
        // Define prayer order for proper logic
        $prayerOrder = ['subuh', 'dzuhur', 'ashar', 'magrib', 'isya'];
        
        foreach ($prayerOrder as $key) {
            if (isset($prayerTimes[$key])) {
                if ($now >= $prayerTimes[$key]['time']) {
                    $current = $key;
                } else {
                    break;
                }
            }
        }
        
        // If current time is before all prayers, return the last prayer from yesterday
        return $current ?? 'isya';
    }

    private function getNextPrayer($prayerTimes)
    {
        $now = $this->prayerNow()->format('H:i');
        
        // Define prayer order for proper logic
        $prayerOrder = ['subuh', 'dzuhur', 'ashar', 'magrib', 'isya'];
        
        foreach ($prayerOrder as $key) {
            if (isset($prayerTimes[$key])) {
                if ($now < $prayerTimes[$key]['time']) {
                    return $key;
                }
            }
        }
        
        // If no prayer is left today, return tomorrow's first prayer
        return 'subuh';
    }

    private function prayerNow(): Carbon
    {
        return now(self::PRAYER_TIMEZONE);
    }

    private function prayerLocation(): array
    {
        return [
            'label' => 'Jakarta Timur, DKI Jakarta, Indonesia',
            'latitude' => -6.225014,
            'longitude' => 106.900447,
        ];
    }

    private function fetchPrayerTimingsByAddress(Carbon $date): ?array
    {
        $location = $this->prayerLocation();

        return $this->requestPrayerTimings('https://api.aladhan.com/v1/timingsByAddress/' . $date->format('d-m-Y'), [
            'address' => $location['label'],
            'method' => self::PRAYER_METHOD,
            'school' => self::PRAYER_SCHOOL,
        ]);
    }

    private function fetchPrayerTimingsByCoordinates(Carbon $date, float $latitude, float $longitude): ?array
    {
        return $this->requestPrayerTimings('https://api.aladhan.com/v1/timings/' . $date->format('d-m-Y'), [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'method' => self::PRAYER_METHOD,
            'school' => self::PRAYER_SCHOOL,
        ]);
    }

    private function requestPrayerTimings(string $url, array $query): ?array
    {
        try {
            $response = Http::acceptJson()
                ->timeout(8)
                ->retry(2, 500)
                ->get($url, $query);

            $timings = data_get($response->json(), 'data.timings');

            return is_array($timings) ? $timings : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function buildPrayerTimes(array $timings): array
    {
        $definitions = [
            'subuh' => ['name' => 'Subuh', 'api_key' => 'Fajr', 'icon' => 'subuh'],
            'dzuhur' => ['name' => 'Dzuhur', 'api_key' => 'Dhuhr', 'icon' => 'dzuhur'],
            'ashar' => ['name' => 'Ashar', 'api_key' => 'Asr', 'icon' => 'ashar'],
            'magrib' => ['name' => 'Magrib', 'api_key' => 'Maghrib', 'icon' => 'magrib'],
            'isya' => ['name' => 'Isya', 'api_key' => 'Isha', 'icon' => 'isya'],
        ];

        $prayerTimes = [];

        foreach ($definitions as $key => $definition) {
            $time = data_get($timings, $definition['api_key']);

            if (! is_string($time)) {
                return $this->fallbackPrayerTimes($this->prayerNow());
            }

            $prayerTimes[$key] = [
                'name' => $definition['name'],
                'time' => $this->normalizePrayerTime($time),
                'icon' => $definition['icon'],
                'description' => 'Waktu sholat ' . $definition['name'],
            ];
        }

        return $prayerTimes;
    }

    private function normalizePrayerTime(string $time): string
    {
        if (preg_match('/(\d{1,2}):(\d{2})/', $time, $matches) === 1) {
            return sprintf('%02d:%02d', (int) $matches[1], (int) $matches[2]);
        }

        try {
            return Carbon::parse($time, self::PRAYER_TIMEZONE)->format('H:i');
        } catch (\Throwable $e) {
            return $time;
        }
    }

    private function fallbackPrayerTimes(Carbon $date): array
    {
        $month = (int) $date->copy()->timezone(self::PRAYER_TIMEZONE)->format('n');

        $fallbackByMonth = [
            1 => ['04:25', '11:59', '15:25', '18:09', '19:22'],
            2 => ['04:31', '12:02', '15:26', '18:11', '19:22'],
            3 => ['04:36', '11:58', '15:19', '18:02', '19:11'],
            4 => ['04:34', '11:51', '15:12', '17:48', '18:59'],
            5 => ['04:36', '11:48', '15:09', '17:45', '18:54'],
            6 => ['04:38', '11:49', '15:11', '17:47', '18:56'],
            7 => ['04:41', '11:54', '15:15', '17:51', '19:00'],
            8 => ['04:39', '11:55', '15:16', '17:52', '19:00'],
            9 => ['04:31', '11:49', '15:06', '17:42', '18:50'],
            10 => ['04:19', '11:37', '14:54', '17:31', '18:40'],
            11 => ['04:09', '11:33', '14:55', '17:33', '18:44'],
            12 => ['04:11', '11:45', '15:10', '17:49', '19:01'],
        ];

        [$subuh, $dzuhur, $ashar, $magrib, $isya] = $fallbackByMonth[$month] ?? $fallbackByMonth[4];

        return [
            'subuh' => [
                'name' => 'Subuh',
                'time' => $subuh,
                'icon' => 'subuh',
                'description' => 'Waktu sholat Subuh',
            ],
            'dzuhur' => [
                'name' => 'Dzuhur',
                'time' => $dzuhur,
                'icon' => 'dzuhur',
                'description' => 'Waktu sholat Dzuhur',
            ],
            'ashar' => [
                'name' => 'Ashar',
                'time' => $ashar,
                'icon' => 'ashar',
                'description' => 'Waktu sholat Ashar',
            ],
            'magrib' => [
                'name' => 'Magrib',
                'time' => $magrib,
                'icon' => 'magrib',
                'description' => 'Waktu sholat Magrib',
            ],
            'isya' => [
                'name' => 'Isya',
                'time' => $isya,
                'icon' => 'isya',
                'description' => 'Waktu sholat Isya',
            ],
        ];
    }

    private function buildDkmViewData(array $overrides = []): array
    {
        $sectionMeta = $this->dkmSectionMeta();

        $dkm = Dkm::get()
            ->sortBy(function ($member) {
                $sectionOrder = $this->dkmSectionOrderForMember($member);
                $coordinatorOrder = $this->normalizeDkmJabatan($this->dkmCoordinatorLabel($member));
                $seksiOrder = $this->normalizeDkmJabatan($this->dkmSeksiLabel($member));
                $jabatanOrder = $this->dkmJabatanRank($member->jabatan);
                $namaOrder = strtolower($member->nama ?? '');

                return sprintf('%03d-%s-%s-%03d-%s', $sectionOrder, $coordinatorOrder, $seksiOrder, $jabatanOrder, $namaOrder);
            })
            ->values();

        $dkmSections = collect($sectionMeta)
            ->map(function ($meta, $key) use ($dkm) {
                $members = $dkm
                    ->filter(fn ($member) => $this->dkmSectionKeyForMember($member) === $key)
                    ->values();

                if ($members->isEmpty()) {
                    return null;
                }

                $sectionData = $members
                    ->groupBy(fn ($member) => $this->dkmCoordinatorLabel($member))
                    ->map(function ($coordinatorMembers, $coordinatorLabel) {
                        return (object) [
                            'nama' => $coordinatorLabel,
                            'seksi' => $coordinatorMembers
                                ->groupBy(fn ($member) => $this->dkmSeksiLabel($member))
                                ->map(function ($seksiMembers, $seksiLabel) {
                                    return (object) [
                                        'nama' => $seksiLabel,
                                        'dkms' => $seksiMembers->values(),
                                    ];
                                })
                                ->values(),
                        ];
                    })
                    ->values();

                return [
                    'key' => $key,
                    'meta' => $meta,
                    'data' => $sectionData,
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

    private function dkmFormViewData(): array
    {
        return [
            'coordinatorOptions' => $this->dkmCoordinatorOptions(),
            'jabatanOptions' => $this->dkmJabatanOptions(),
        ];
    }

    private function dkmValidationRules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'seksi_id' => ['nullable', 'integer'],
        ];
    }

    private function sanitizeDkmPayload(array $payload): array
    {
        foreach ($payload as $key => $value) {
            if (is_string($value)) {
                $payload[$key] = trim($value);
            }
        }

        foreach (['bio', 'foto', 'email', 'no_hp', 'alamat', 'seksi_id'] as $field) {
            if (!array_key_exists($field, $payload)) {
                continue;
            }

            if ($payload[$field] === '') {
                $payload[$field] = null;
            }
        }

        return $payload;
    }

    private function dkmCoordinatorOptions(): array
    {
        $defaults = [
            'Penasehat DKM 2026',
            'Pengurus inti DKM 2026',
            'Koordinator Keagamaan/Ibadah',
            'Koordinator Keamanan',
            'Koordinator Pembangunan',
            'Koordinator Perlengkapan & Kebersihan',
            'Koordinator Hubungan Masyarakat & Informasi',
        ];

        return collect($defaults)
            ->merge(
                Dkm::query()
                    ->whereNotNull('bio')
                    ->pluck('bio')
                    ->map(fn ($value) => trim((string) $value))
                    ->filter()
            )
            ->unique()
            ->values()
            ->all();
    }

    private function dkmJabatanOptions(): array
    {
        $defaults = [
            'Pelindung',
            'Penanggung Jawab',
            'Penasehat',
            'Ketua',
            'Wakil Ketua',
            'Sekretaris',
            'Wakil Sekretaris',
            'Bendahara',
            'Wakil Bendahara',
            'Imam Muqim',
            'Imam Rawatib',
            'Seksi Majelis Taklim',
            'Seksi Guru Ngaji TPA & ZIS',
            'Seksi Pemulasaran Jenazah',
            'Seksi Muadzin',
            'Seksi Qurban',
            'Seksi Umum',
            'Seksi Ketertiban Ibadah',
            'Seksi Parkir Kendaraan',
            'Seksi Harwat/Renovasi',
            'Seksi Marbot & Kelistrikan',
            'Seksi Umum & Pemotongan Rumput',
            'Seksi Perlengkapan Jenazah',
            'Seksi Perlengkapan Masjid',
            'Seksi Kebersihan Sektor Dalam',
            'Seksi Kebersihan Sektor Serambi',
            'Seksi Kebersihan Sektor Luar',
            'Seksi Hubungan Masyarakat',
            'Seksi Informasi & Teknologi',
            'Seksi Tata Suara/Sound System',
        ];

        return collect($defaults)
            ->merge(
                Dkm::query()
                    ->whereNotNull('jabatan')
                    ->pluck('jabatan')
                    ->map(fn ($value) => trim((string) $value))
                    ->filter()
            )
            ->unique()
            ->values()
            ->all();
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

    public function adminDashboard()
    {
        // Real-time statistics for admin dashboard
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_kajian' => \App\Models\Kajian::count(),
            'total_videos' => \App\Models\Video::count(),
            'total_media' => \App\Models\Gallery::count(),
            'total_dkm' => \App\Models\Dkm::count(),
            'total_donasi' => \App\Models\Donasi::count(),
        ];

        // User growth data
        $userGrowthData = [];
        $totalUsers = 0;
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $newUsers = \App\Models\User::whereDate('created_at', $date)->count();
            $totalUsers += $newUsers;
            
            $userGrowthData[] = [
                'date' => $date->format('Y-m-d'),
                'new_users' => $newUsers,
                'total_users' => $totalUsers
            ];
        }

        // Kajian categories
        $kajianCategories = \App\Models\Kajian::selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->get()
            ->pluck('count', 'kategori')
            ->toArray();

        // User roles
        $userRoles = [
            'admin' => \App\Models\User::where('role', 'admin')->count(),
            'user' => \App\Models\User::where('role', 'user')->count(),
        ];

        // DKM structure
        $dkmStructure = [
            'Ketua' => \App\Models\Dkm::where('jabatan', 'Ketua')->count(),
            'Wakil Ketua' => \App\Models\Dkm::where('jabatan', 'Wakil Ketua')->count(),
            'Sekretaris' => \App\Models\Dkm::where('jabatan', 'Sekretaris')->count(),
            'Bendahara' => \App\Models\Dkm::where('jabatan', 'Bendahara')->count(),
        ];

        // Activity timeline
        $activityTimeline = collect([
            ['type' => 'kajian', 'title' => 'Kajian Baru Ditambahkan', 'time' => '2 jam lalu'],
            ['type' => 'user', 'title' => 'User Baru Mendaftar', 'time' => '5 jam lalu'],
            ['type' => 'donasi', 'title' => 'Donasi Masuk', 'time' => '1 hari lalu'],
        ]);

        // Recent kajian and donations
        $recentKajian = \App\Models\Kajian::with(['ustadz'])->latest()->take(5)->get();
        $recentDonations = \App\Models\Donasi::with(['user'])->latest()->take(5)->get();

        // Growth percentages
        $thisMonthUsers = \App\Models\User::whereMonth('created_at', now()->month)->count();
        $lastMonthUsers = \App\Models\User::whereMonth('created_at', now()->subMonth()->month)->count();
        $userGrowthPercentage = $lastMonthUsers > 0 ? (($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 0;

        $thisMonthKajian = \App\Models\Kajian::whereMonth('created_at', now()->month)->count();
        $lastMonthKajian = \App\Models\Kajian::whereMonth('created_at', now()->subMonth()->month)->count();
        $kajianGrowthPercentage = $lastMonthKajian > 0 ? (($thisMonthKajian - $lastMonthKajian) / $lastMonthKajian) * 100 : 0;

        return view('admin.dashboard-dropdown', compact(
            'stats', 
            'userGrowthData', 
            'kajianCategories', 
            'userRoles', 
            'dkmStructure', 
            'activityTimeline',
            'recentKajian', 
            'recentDonations',
            'userGrowthPercentage',
            'kajianGrowthPercentage'
        ));
    }

    private function masjidContactData(): array
    {
        // Cari Ketua DKM terlebih dahulu
        $ketua = Dkm::where('jabatan', 'Ketua')->first();
        
        // Jika tidak ada Ketua, cari Wakil Ketua
        if (!$ketua) {
            $ketua = Dkm::where('jabatan', 'Wakil Ketua')->first();
        }
        
        // Jika masih tidak ada, gunakan sorting logic
        if (!$ketua) {
            $ketua = Dkm::get()
                ->sortBy(function ($member) {
                    return sprintf('%03d-%s', $this->dkmJabatanRank($member->jabatan), strtolower($member->nama ?? ''));
                })
                ->first();
        }

        $address = 'Masjid Al-Hasanah, Komplek Pushubad Cijantung Jl. Radar VII, Kel. Kalisari, Kec. Pasar Rebo, Jakarta Timur 13790';
        $phone = $ketua->no_hp ?? '+6281934178960';
        $email = $ketua->email ?? 'info@masjidalhasanah.id';

        // Jika Ketua tidak punya nomor HP, gunakan Sugeng Riyadi sebagai kontak
        $contactName = 'Sugeng Riyadi';
        $contactRole = 'Humas';
        
        // Tapi jika Ketua ada nomornya, gunakan nama Ketua
        if ($ketua && $ketua->no_hp) {
            $contactName = $ketua->nama;
            $contactRole = $ketua->jabatan;
        }

        // Link Google Maps Masjid Al-Hasanah yang akurat
        $masjidMapsUrl = 'https://maps.app.goo.gl/RBJaf2bFpCQsw7Vf7';
        
        return [
            'address' => $address,
            'mapsEmbed' => 'https://www.google.com/maps?q=Masjid+Al-Hasanah+Cijantung+Jakarta+Timur&output=embed',
            'mapsLink' => $masjidMapsUrl,
            'whatsapp' => $phone,
            'whatsappLink' => 'https://wa.me/' . $this->normalizeWhatsappNumber($phone),
            'email' => $email,
            'contactName' => $contactName,
            'contactRole' => $contactRole,
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

    private function dkmSectionKeyForMember($member): string
    {
        $jabatan = $this->normalizeDkmJabatan($member->jabatan ?? null);
        $group = $this->normalizeDkmJabatan($member->bio ?? null);

        return match (true) {
            in_array($jabatan, ['pelindung', 'penanggung jawab', 'penasehat', 'penasihat', 'ketua'], true) => 'pimpinan',
            in_array($jabatan, ['wakil ketua', 'sekretaris', 'sekertaris', 'sekretaris umum', 'wakil sekretaris', 'bendahara', 'wakil bendahara'], true) => 'harian',
            str_contains($group, 'keagamaan') || str_contains($group, 'ibadah') => 'ibadah',
            in_array($jabatan, ['imam muqim', 'imam rawatib', 'imam besar', 'imam', 'khatib', 'muadzin', 'muazin'], true) => 'ibadah',
            $group !== '' || str_starts_with($jabatan, 'seksi') || str_starts_with($jabatan, 'koordinator') || str_starts_with($jabatan, 'ketua bidang') => 'seksi',
            default => $this->dkmSectionKey($member->jabatan ?? null),
        };
    }

    private function dkmSectionOrderForMember($member): int
    {
        return match ($this->dkmSectionKeyForMember($member)) {
            'pimpinan' => 1,
            'harian' => 2,
            'ibadah' => 3,
            'seksi' => 4,
            default => 5,
        };
    }

    private function dkmCoordinatorLabel($member): string
    {
        $group = trim((string) ($member->bio ?? ''));

        if ($group !== '') {
            return $group;
        }

        return match ($this->dkmSectionKeyForMember($member)) {
            'pimpinan' => 'Pimpinan & Pembina',
            'harian' => 'Pengurus Harian',
            'ibadah' => 'Pelayanan Ibadah',
            'seksi' => 'Bidang Pelayanan',
            default => 'Anggota Pendukung',
        };
    }

    private function dkmSeksiLabel($member): string
    {
        $jabatan = trim((string) ($member->jabatan ?? ''));

        return $jabatan !== '' ? $jabatan : 'Anggota';
    }

    private function dkmJabatanRank(?string $jabatan): int
    {
        $normalized = $this->normalizeDkmJabatan($jabatan);

        return match (true) {
            in_array($normalized, ['pelindung', 'penanggung jawab', 'penasehat', 'penasihat'], true) => 5,
            $normalized === 'ketua' => 10,
            $normalized === 'wakil ketua' => 20,
            in_array($normalized, ['sekretaris', 'sekertaris', 'sekretaris umum'], true) => 30,
            $normalized === 'wakil sekretaris' => 40,
            $normalized === 'bendahara' => 50,
            $normalized === 'wakil bendahara' => 60,
            in_array($normalized, ['imam muqim', 'imam rawatib'], true) => 70,
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

    public function visiMisi()
    {
        return view('visi-misi.index');
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

        $donasi = Donasi::create([
            'user_id' => Auth::id(),
            'nominal' => $request->nominal,
            'jenis' => $request->jenis,
            'status' => 'pending', // 🔥 tetap pending
            'metode' => 'qris'
        ]);

        return redirect('/donasi/'.$donasi->id);
    }
    public function kas()
    {
        $kas = Kas::latest()->get();

        $totalMasuk = Kas::where('tipe','masuk')->sum('nominal');
        $totalKeluar = Kas::where('tipe','keluar')->sum('nominal');

        $saldo = $totalMasuk - $totalKeluar;

        return view('kas.index', compact(
            'kas',
            'totalMasuk',
            'totalKeluar',
            'saldo'
        ));
    }

    public function kasStore(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'nominal' => 'required|numeric',
            'tipe' => 'required',
            'tanggal' => 'required'
        ]);

        Kas::create($request->all());

        return back()->with('success','Data kas ditambahkan');
    }

    public function donasiDetail($id)
    {
        $donasi = Donasi::findOrFail($id);

        return view('donasi.qris', compact('donasi'));
    }

    public function donasiHistory()
    {
        $donasi = Donasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('donasi.history', compact('donasi'));
    }

    }
