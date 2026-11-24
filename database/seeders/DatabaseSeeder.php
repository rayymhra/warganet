<?php
namespace Database\Seeders;
use App\Models\{User, Schedule, Announcement, Business};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $a = User::create(['name' => 'Admin RT', 'email' => 'admin@warganet.test', 'password' => Hash::make('password')]);
        $a->forceFill(['role' => 'admin'])->save();
        User::create(['name' => 'Warga Demo', 'email' => 'warga@warganet.test', 'password' => Hash::make('password')]);

        Schedule::create(['title' => 'Pengangkutan Sampah', 'category' => 'Waste', 'description' => 'Siapkan sampah sebelum jam 07.00',
            'date' => now()->addDay(), 'start_time' => '07:00', 'location' => 'Gerbang RW 03', 'status' => 'published', 'created_by' => $a->id]);
        Schedule::create(['title' => 'Posyandu Balita', 'category' => 'Health',
            'date' => now()->addDays(4), 'start_time' => '09:00', 'end_time' => '11:00', 'location' => 'Balai Warga', 'status' => 'published', 'created_by' => $a->id]);
        Announcement::create(['title' => 'Kerja Bakti Akhir Pekan', 'slug' => 'kerja-bakti-1', 'category' => 'Community',
            'content' => 'Mari bersihkan saluran air bersama.', 'is_important' => true, 'status' => 'published',
            'published_at' => now(), 'created_by' => $a->id]);
        Business::create(['name' => 'Warung Bu Sari', 'category' => 'Food', 'description' => 'Makanan rumahan harian.',
            'address' => 'Jl. Melati No. 4', 'phone' => '081234567890', 'operating_hours' => '06.00 - 20.00',
            'status' => 'published', 'created_by' => $a->id]);
    }
}