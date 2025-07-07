<?php
namespace Database\Seeders;

use App\Models\GeneralInformation;
use Illuminate\Database\Seeder;

class GeneralInformationSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data lama jika ada
        GeneralInformation::truncate();
        
        // Enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Data untuk video YouTube (WAJIB dengan name "Informasi dan Alur Pendaftaran")
        GeneralInformation::create([
            'type' => 'alur_pendaftaran',
            'name' => 'Informasi dan Alur Pendaftaran',
            'description' => 'https://www.youtube.com/watch?v=3JZ_D3ELwOQ', // Video tutorial pendaftaran mahasiswa
        ]);

        // Data untuk accordion Informasi Umum
        GeneralInformation::create([
            'type' => 'konsentrasi',
            'name' => 'Konsentrasi Program',
            'description' => '<p>Program ini memiliki beberapa konsentrasi utama yang dapat dipilih mahasiswa sesuai dengan minat dan bakat mereka.</p><p>Setiap konsentrasi dirancang untuk memberikan keahlian spesifik yang dibutuhkan di industri.</p>',
        ]);

        GeneralInformation::create([
            'type' => 'prospek_karir',
            'name' => 'Prospek Karir',
            'description' => '<p>Lulusan program ini memiliki prospek karir yang sangat luas di berbagai sektor industri.</p><p>Beberapa posisi yang dapat diisi antara lain: Software Developer, Data Analyst, Project Manager, dan banyak lagi.</p>',
        ]);

        GeneralInformation::create([
            'type' => 'keunggulan',
            'name' => 'Keunggulan Program',
            'description' => '<p>Program ini memiliki keunggulan dalam hal kurikulum yang selalu update dengan perkembangan teknologi terkini.</p><p>Didukung oleh dosen-dosen berpengalaman dan fasilitas laboratorium yang lengkap.</p>',
        ]);

        GeneralInformation::create([
            'type' => 'sks_matakuliah',
            'name' => 'Struktur SKS dan Mata Kuliah',
            'description' => '<p>Total SKS yang harus ditempuh adalah 144 SKS yang terbagi dalam 8 semester.</p><p>Mata kuliah dirancang secara bertahap dari dasar hingga tingkat lanjut dengan fokus pada praktik dan teori yang seimbang.</p>',
        ]);

        GeneralInformation::create([
            'type' => 'fasilitas',
            'name' => 'Fasilitas Pendukung',
            'description' => '<p>Kampus dilengkapi dengan laboratorium komputer terbaru dan akses internet berkecepatan tinggi.</p><p>Perpustakaan digital dengan koleksi buku dan jurnal internasional yang lengkap.</p>',
        ]);
    }
}
