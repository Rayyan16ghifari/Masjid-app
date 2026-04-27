<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = $this->getAllSettings();
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:1000',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'app_favicon' => 'nullable|image|mimes:ico,png|max:512',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        $settings = $this->getAllSettings();

        // Handle logo upload
        if ($request->hasFile('app_logo')) {
            // Delete old logo if exists
            if (!empty($settings['general']['app_logo']) && Storage::disk('public')->exists($settings['general']['app_logo'])) {
                Storage::disk('public')->delete($settings['general']['app_logo']);
            }

            $file = $request->file('app_logo');
            $filename = 'logo.' . $file->getClientOriginalExtension();
            $validated['app_logo'] = $file->storeAs('settings', $filename, 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('app_favicon')) {
            // Delete old favicon if exists
            if (!empty($settings['general']['app_favicon']) && Storage::disk('public')->exists($settings['general']['app_favicon'])) {
                Storage::disk('public')->delete($settings['general']['app_favicon']);
            }

            $file = $request->file('app_favicon');
            $filename = 'favicon.' . $file->getClientOriginalExtension();
            $validated['app_favicon'] = $file->storeAs('settings', $filename, 'public');
        }

        // Update settings
        $settings['general'] = array_merge($settings['general'] ?? [], $validated);
        $this->saveSettings($settings);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan umum berhasil diperbarui.');
    }

    /**
     * Update masjid settings
     */
    public function updateMasjid(Request $request)
    {
        $validated = $request->validate([
            'masjid_name' => 'required|string|max:255',
            'masjid_address' => 'required|string|max:500',
            'masjid_phone' => 'nullable|string|max:20',
            'masjid_email' => 'nullable|email|max:255',
            'masjid_website' => 'nullable|url|max:255',
            'masjid_maps_link' => 'nullable|url|max:500',
            'masjid_embed_link' => 'nullable|url|max:500',
            'masjid_description' => 'nullable|string|max:1000',
            'masjid_vision' => 'nullable|string|max:1000',
            'masjid_mission' => 'nullable|string|max:1000',
        ]);

        $settings = $this->getAllSettings();
        $settings['masjid'] = array_merge($settings['masjid'] ?? [], $validated);
        $this->saveSettings($settings);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan masjid berhasil diperbarui.');
    }

    /**
     * Update prayer times settings
     */
    public function updatePrayer(Request $request)
    {
        $validated = $request->validate([
            'prayer_method' => 'required|in:1,2,3,4,5,6,7,8',
            'prayer_asr_method' => 'required|in:standard,hanafi',
            'prayer_high_latitude' => 'required|in:angle_based,night_based',
            'prayer_adjustment' => 'nullable|array',
            'prayer_adjustment.fajr' => 'nullable|integer|min:-30|max:30',
            'prayer_adjustment.dhuhr' => 'nullable|integer|min:-30|max:30',
            'prayer_adjustment.asr' => 'nullable|integer|min:-30|max:30',
            'prayer_adjustment.maghrib' => 'nullable|integer|min:-30|max:30',
            'prayer_adjustment.isha' => 'nullable|integer|min:-30|max:30',
        ]);

        $settings = $this->getAllSettings();
        $settings['prayer'] = array_merge($settings['prayer'] ?? [], $validated);
        $this->saveSettings($settings);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan waktu sholat berhasil diperbarui.');
    }

    /**
     * Update notification settings
     */
    public function updateNotification(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'required|boolean',
            'sms_notifications' => 'required|boolean',
            'push_notifications' => 'required|boolean',
            'notification_email' => 'nullable|email|max:255',
            'notification_sms_number' => 'nullable|string|max:20',
            'kajian_reminder' => 'required|boolean',
            'kajian_reminder_hours' => 'required|integer|min:1|max:48',
            'donation_notification' => 'required|boolean',
        ]);

        $settings = $this->getAllSettings();
        $settings['notification'] = array_merge($settings['notification'] ?? [], $validated);
        $this->saveSettings($settings);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan notifikasi berhasil diperbarui.');
    }

    /**
     * Update maintenance settings
     */
    public function updateMaintenance(Request $request)
    {
        $validated = $request->validate([
            'maintenance_mode' => 'required|boolean',
            'maintenance_message' => 'nullable|string|max:1000',
            'maintenance_end_time' => 'nullable|date',
            'allowed_ips' => 'nullable|string',
            'backup_enabled' => 'required|boolean',
            'backup_frequency' => 'required|in:daily,weekly,monthly',
            'backup_retention' => 'required|integer|min:1|max:365',
        ]);

        $settings = $this->getAllSettings();
        $settings['maintenance'] = array_merge($settings['maintenance'] ?? [], $validated);
        $this->saveSettings($settings);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan maintenance berhasil diperbarui.');
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        // Clear application cache
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Cache berhasil dibersihkan.');
    }

    /**
     * Backup database
     */
    public function backup()
    {
        try {
            // Create backup
            \Artisan::call('backup:run');
            
            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Get all settings from storage
     */
    private function getAllSettings()
    {
        $storagePath = storage_path('app/data/settings.json');
        
        if (!file_exists($storagePath)) {
            // Create directory if not exists
            $dir = dirname($storagePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // Create default settings
            $defaultSettings = [
                'general' => [
                    'app_name' => 'Masjid Al-Hasanah',
                    'app_description' => 'Aplikasi Manajemen Masjid Modern',
                    'app_logo' => null,
                    'app_favicon' => null,
                    'contact_email' => 'info@masjidalhasanah.id',
                    'contact_phone' => '+6281934178960',
                    'contact_address' => 'Komplek Pushubad Cijantung Jl. Radar VII Kel. Kalisari, Kec. Pasar Rebo, Jakarta Timur 13790',
                    'social_facebook' => null,
                    'social_twitter' => null,
                    'social_instagram' => null,
                    'social_youtube' => null,
                ],
                'masjid' => [
                    'masjid_name' => 'Masjid Al-Hasanah',
                    'masjid_address' => 'Komplek Pushubad Cijantung Jl. Radar VII Kel. Kalisari, Kec. Pasar Rebo, Jakarta Timur 13790',
                    'masjid_phone' => '+6281934178960',
                    'masjid_email' => 'info@masjidalhasanah.id',
                    'masjid_website' => 'https://masjidalhasanah.id',
                    'masjid_maps_link' => 'https://maps.app.goo.gl/RBJaf2bFpCQsw7Vf7',
                    'masjid_embed_link' => 'https://www.google.com/maps?q=Masjid+Al-Hasanah+Cijantung+Jakarta+Timur&output=embed',
                    'masjid_description' => 'Masjid Al-Hasanah adalah masjid modern yang menyediakan berbagai kegiatan keagamaan dan sosial.',
                    'masjid_vision' => 'Menjadi masjid yang menjadi pusat kegiatan umat dan pencerah masyarakat.',
                    'masjid_mission' => 'Menyelenggarakan kegiatan keagamaan, pendidikan, dan sosial untuk kemajuan umat.',
                ],
                'prayer' => [
                    'prayer_method' => '2',
                    'prayer_asr_method' => 'standard',
                    'prayer_high_latitude' => 'angle_based',
                    'prayer_adjustment' => [
                        'fajr' => 0,
                        'dhuhr' => 0,
                        'asr' => 0,
                        'maghrib' => 0,
                        'isha' => 0,
                    ],
                ],
                'notification' => [
                    'email_notifications' => true,
                    'sms_notifications' => false,
                    'push_notifications' => true,
                    'notification_email' => 'info@masjidalhasanah.id',
                    'notification_sms_number' => null,
                    'kajian_reminder' => true,
                    'kajian_reminder_hours' => 2,
                    'donation_notification' => true,
                ],
                'maintenance' => [
                    'maintenance_mode' => false,
                    'maintenance_message' => 'Situs sedang dalam maintenance. Silakan kembali beberapa saat lagi.',
                    'maintenance_end_time' => null,
                    'allowed_ips' => '127.0.0.1',
                    'backup_enabled' => true,
                    'backup_frequency' => 'daily',
                    'backup_retention' => 30,
                ],
            ];
            
            file_put_contents($storagePath, json_encode($defaultSettings, JSON_PRETTY_PRINT));
            return $defaultSettings;
        }

        return json_decode(file_get_contents($storagePath), true);
    }

    /**
     * Save settings to storage
     */
    private function saveSettings($settings)
    {
        $storagePath = storage_path('app/data/settings.json');
        file_put_contents($storagePath, json_encode($settings, JSON_PRETTY_PRINT));
    }
}
