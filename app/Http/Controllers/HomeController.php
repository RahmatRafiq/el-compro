<?php
namespace App\Http\Controllers;

use App\Models\AboutApp;
use App\Models\Article;
use App\Models\Category;
use App\Models\Course;
use App\Models\GeneralInformation;
use App\Models\Lecturers;
use App\Models\Virtual;

class HomeController extends Controller
{
    public function index()
    {

        $articles = Article::latest()->take(5)->get();
        $articles = $articles->map(function ($article) {
            return [
                'id'         => $article->id,
                'title'      => $article->title,
                'image'      => $article->getFirstMediaUrl('article-image') ?: asset('images/default-article.png'),
                'view_count' => $article->view_count,
                'slug'       => $article->slug,
            ];
        });

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
            'articles'               => $articles,
            'aboutApp'               => $aboutApp,
            'lecturers'              => $lecturers,
            'virtualTours'           => $virtualTours,
            'concentrationData'      => $concentrationData,
            'generalInformationData' => $generalInformationData,
        ]);
    }

    public function lecturers()
    {

        $aboutApp = AboutApp::first();

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
            'aboutApp'  => $aboutApp,
        ]);
    }

    public function courses()
    {

        $aboutApp = AboutApp::first();

        $courses = Course::with('lecturers')->get();

        return inertia('Courses', [
            'courses'  => $courses,
            'aboutApp' => $aboutApp,
        ]);
    }

    public function articles()
    {
        $categories = Category::where('type', 'article')->get();

        $categoriesWithArticles = $categories->map(function ($category) {
            return [
                'name'     => $category->name,
                'articles' => Article::where('category_id', $category->id)
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(fn($article) => [
                        'id'         => $article->id,
                        'title'      => $article->title,
                        'image'      => $article->hasMedia('article-image') ? $article->getFirstMediaUrl('article-image') : null,
                        'view_count' => $article->view_count,
                        'slug'       => $article->slug,
                    ]),
            ];
        });

        return inertia('Articles', [
            'categories' => $categoriesWithArticles,
        ]);
    }

}
