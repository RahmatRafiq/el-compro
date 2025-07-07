<?php

namespace Database\Seeders;

use App\Models\AboutApp;
use Illuminate\Database\Seeder;

class AboutAppSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus data lama jika ada
        AboutApp::truncate();
        
        // Enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        AboutApp::create([
            'title' => 'Tentang Program Studi Teknologi Informasi',
            'description' => 'Program Studi Teknologi Informasi merupakan program studi yang berfokus pada pengembangan teknologi informasi dan komunikasi untuk mendukung kebutuhan industri dan masyarakat. Program ini dirancang untuk menghasilkan lulusan yang kompeten dalam bidang teknologi informasi dengan kemampuan analisis, desain, implementasi, dan evaluasi sistem informasi.',
            'greeting' => 'Selamat datang di Program Studi Teknologi Informasi. Kami berkomitmen untuk memberikan pendidikan berkualitas tinggi dalam bidang teknologi informasi yang sesuai dengan perkembangan zaman dan kebutuhan industri.',
            'vision_mission' => 'VISI: Menjadi program studi unggul dalam bidang teknologi informasi yang menghasilkan lulusan berkualitas, berkarakter, dan berdaya saing global pada tahun 2030.

MISI: 
1. Menyelenggarakan pendidikan tinggi yang berkualitas dalam bidang teknologi informasi
2. Mengembangkan penelitian yang inovatif dan bermanfaat bagi masyarakat
3. Melaksanakan pengabdian kepada masyarakat dalam bidang teknologi informasi
4. Menjalin kerjasama dengan berbagai pihak untuk mengembangkan program studi',
            'history' => 'Program Studi Teknologi Informasi didirikan pada tahun 2010 sebagai respons terhadap kebutuhan industri akan tenaga ahli di bidang teknologi informasi. Sejak didirikan, program studi ini telah mengalami perkembangan pesat dan telah meluluskan lebih dari 1000 alumni yang tersebar di berbagai industri teknologi informasi di Indonesia dan luar negeri.',
            'contact_email' => 'info@ti.ac.id',
            'contact_phone' => '+62 21 1234 5678',
            'contact_address' => 'Jl. Teknologi Informasi No. 123, Jakarta Selatan, DKI Jakarta 12345',
        ]);
    }
}
