<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\GeneralInformation;
use App\Models\Lecturers;
use App\Models\Virtual;

class HomeController extends Controller
{
    public function index()
    {
        $generalInformationCategories = Category::where('type', 'general_information')->get();
        $generalInformationData       = GeneralInformation::whereIn('name', $generalInformationCategories->pluck('name'))->get();
        $virtualTours                 = Virtual::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'virtual_tours');
            })
            ->get();
        $concentrationData = GeneralInformation::where('type', 'Konsentrasi')
            ->select('id', 'name', 'description')
            ->get();

        $registrationFlowData = GeneralInformation::where('name', 'Informasi dan Alur Pendaftaran')->first();

        $lecturers = Lecturers::with('courses')->take(2)->get()->map(function ($lecturer) {
            return [
                'id'      => $lecturer->id,
                'name'    => $lecturer->name,
                'image'   => $lecturer->getFirstMediaUrl('lecturer-image') ?: asset('images/default-avatar.png'), // Jika tidak ada gambar, gunakan default
                'courses' => $lecturer->courses->map(fn($course) => [
                    'id'   => $course->id,
                    'name' => $course->name,
                ]),
            ];
        });

        return inertia('Home', [
            'generalInformationCategories' => $generalInformationCategories,
            'generalInformationData'       => $generalInformationData,
            'virtualTours'                 => $virtualTours,
            'registrationFlowData'         => $registrationFlowData,
            'lecturers'                    => $lecturers,
            'concentrationData'            => $concentrationData,
        ]);
    }

}
