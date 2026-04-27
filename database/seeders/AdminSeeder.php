<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@masjidalhasanah.id')->exists()) {
            User::create([
                'name' => 'Admin Masjid Al-Hasanah',
                'email' => 'admin@masjidalhasanah.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]);
            
            $this->command->info('✅ Akun admin berhasil dibuat!');
            $this->command->info('📧 Email: admin@masjidalhasanah.id');
            $this->command->info('🔑 Password: admin123');
        } else {
            $this->command->info('ℹ️  Akun admin sudah ada!');
            $this->command->info('📧 Email: admin@masjidalhasanah.id');
            $this->command->info('🔑 Password: admin123');
        }
    }
}
