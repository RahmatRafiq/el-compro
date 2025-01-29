<?php

namespace App\Models;

use App\Models\LaporanHarian;
use App\Models\LaporanMingguan;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    public function getDashboardData()
    {
        $data = [
            'total_users' => User::count(),
        ];
        return $data;
    }
}
