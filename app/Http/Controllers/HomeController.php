<?php
namespace App\Http\Controllers;

use App\Models\GeneralInformation;
use App\Models\Lecturers;
use App\Models\Virtual;

class HomeController extends Controller
{
    public function index()
    {
        $generalInformationData = GeneralInformation::whereIn('name', [
            'Keunggulan',
            'Capaian Prestasi',
            'Prospek Karier',
            'Informasi dan Alur Pendaftaran',
        ])->get();
        $virtualTours = Virtual::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'virtual_tours');
            })
            ->get();

        $concentrationData = GeneralInformation::where('type', 'Konsentrasi')
            ->select('id', 'name', 'description')
            ->get();

        $lecturers = Lecturers::with('courses')->take(2)->get()->map(function ($lecturer) {
            return [
                'id'      => $lecturer->id,
                'name'    => $lecturer->name,
                'image'   => $lecturer->getFirstMediaUrl('lecturer-image') ?: asset('images/default-avatar.png'),
                'courses' => $lecturer->courses->map(fn($course) => [
                    'id'   => $course->id,
                    'name' => $course->name,
                ]),
            ];
        });

        return inertia('Home', [
            'generalInformationData' => $generalInformationData,
            'virtualTours'           => $virtualTours,
            'lecturers'              => $lecturers,
            'concentrationData'      => $concentrationData,
        ]);
    }

    public function lecturers()
    {
        $lecturers = Lecturers::with('courses')->get()->map(fn($lecturer) => [
            'id'      => $lecturer->id,
            'name'    => $lecturer->name,
            'image'   => $lecturer->getFirstMediaUrl('lecturer-image') ?: asset('images/default-avatar.png'),
            'courses' => $lecturer->courses->map(fn($course) => [
                'id'   => $course->id,
                'name' => $course->name,
            ]),
        ]);

        return inertia('Lecturers', [
            'lecturers' => $lecturers,
        ]);
    }

}
