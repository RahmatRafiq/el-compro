<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GeneralInformation;
use App\Models\Virtual;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil kategori berdasarkan type
        $generalInformationCategories = Category::where('type', 'general_information')->get();
        $virtualToursCategories = Category::where('type', 'virtual_tours')->get();

        // Mengambil informasi umum
        $generalInformationData = GeneralInformation::whereIn('name', $generalInformationCategories->pluck('name'))->get();

        // Mengambil data virtual tours yang memiliki kategori virtual_tours
        $virtualTours = Virtual::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'virtual_tours');
            })
            ->get();

        return inertia('Home', [
            'generalInformationCategories' => $generalInformationCategories,
            'generalInformationData' => $generalInformationData,
            'virtualTours' => $virtualTours, // Kirim data virtual tours ke frontend
        ]);
    }
}
