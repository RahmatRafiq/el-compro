<?php
namespace App\Http\Controllers;

use App\Models\AboutApp;
use App\Models\Course;
use App\Models\GeneralInformation;
use App\Models\Lecturers;
use App\Models\Virtual;

class HomeController extends Controller
{
    public function index()
    {

        $courses = Course::latest()->take(5)->get();

        $aboutApp = AboutApp::first();

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

        $virtualTours = Virtual::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'virtual_tours');
            })
            ->get();

        $concentrationData = GeneralInformation::where('type', 'Konsentrasi')
            ->select('id', 'name', 'description')
            ->get();

        $generalInformationData = GeneralInformation::whereIn('name', [
            'Keunggulan',
            'Capaian Prestasi',
            'Prospek Karier',
            'Informasi dan Alur Pendaftaran',
        ])
            ->get();

        return inertia('Home', [
            'courses'                => $courses,
            'aboutApp'               => $aboutApp,
            'lecturers'              => $lecturers,
            'virtualTours'           => $virtualTours,
            'concentrationData'      => $concentrationData,
            'generalInformationData' => $generalInformationData,
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

    public function courses()
    {
        $courses = Course::with('lecturers')->get();

        return inertia('Courses', [
            'courses' => $courses,
        ]);
    }
}
