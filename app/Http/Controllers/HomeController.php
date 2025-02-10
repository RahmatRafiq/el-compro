<?php
namespace App\Http\Controllers;

use App\Models\AboutApp;
use App\Models\Article;
use App\Models\Category;
use App\Models\Course;
use App\Models\GeneralInformation;
use App\Models\Lecturers;
use App\Models\Virtual;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function show($slug)
    {
        $aboutApp = AboutApp::first();
        $article = Article::with('media')->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        $popularArticles = Article::with('media')
            ->where('created_at', '>=', now()->subMonth())
            ->orderByDesc('view_count')
            ->take(5)
            ->get(['id', 'slug', 'title', 'view_count', 'created_at'])
            ->map(function ($article) {
                $article->image = $article->getFirstMediaUrl('article-image') ?: null;
                return $article;
            });

        $latestArticles = Article::with('media')
            ->orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'slug', 'title', 'created_at'])
            ->map(function ($article) {
                $article->image = $article->getFirstMediaUrl('article-image') ?: null;
                return $article;
            });

        return inertia('Articles/ArticleDetail', [
            'article'         => [
                'slug'       => $article->slug,
                'id'         => $article->id,
                'title'      => $article->title,
                'content'    => $article->content,
                'image'      => $article->getFirstMediaUrl('article-image') ?: null,
                'view_count' => $article->view_count + 1,
                'created_at' => $article->created_at->format('d M Y'),
            ],
            'popularArticles' => $popularArticles,
            'latestArticles'  => $latestArticles,
            'aboutApp'        => $aboutApp,
        ]);
    }

    public function articlesByCategory($name)
    {
        $aboutApp = AboutApp::first();
        $category = Category::where('name', $name)->where('type', 'article')
            ->firstOrFail();

        $articles = Article::where('category_id', $category->id)
            ->latest()
            ->paginate(10)
            ->through(fn($article) => [
                'id'         => $article->id,
                'title'      => $article->title,
                'image'      => $article->getFirstMediaUrl('article-image') ?: asset('images/default-article.png'),
                'view_count' => $article->view_count,
                'slug'       => $article->slug,
            ]);

        return inertia('Articles/CategoryArticles', [
            'category' => [
                'name' => $category->name,
            ],
            'articles' => $articles,
            'aboutApp' => $aboutApp,
        ]);
    }

    public function index()
    {
        $aboutApp = AboutApp::first();
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
        $aboutApp = AboutApp::first();
        $categories = Category::where('type', 'article')->get();

        $categoriesWithArticles = $categories->map(function ($category) {
            return [
                'name'     => $category->name,
                'articles' => Article::where('category_id', $category->id)
                    ->latest()
                    ->take(4)
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
            'aboutApp'   => $aboutApp,
        ]);
    }

    public function virtualTours()
    {
        $aboutApp = AboutApp::first();
        $virtualTours = Virtual::with('category')
            ->whereHas('category', function ($query) {
                $query->where('type', 'virtual_tours');
            })
            ->get()
            ->map(fn($virtual) => [
                'id'          => $virtual->id,
                'name'        => $virtual->name,
                'slug'        => Str::slug($virtual->name), 
                'url_embed'   => $virtual->url_embed,
                'description' => $virtual->description,
                'category'    => $virtual->category ? $virtual->category->name : null,
            ]);

        return inertia('VirtualTours', [
            'virtualTours' => $virtualTours,
            'aboutApp'     => $aboutApp,
        ]);
    }

    public function virtualTourDetail($name)
    {
        $aboutApp = AboutApp::first();
        $virtual = Virtual::with('category')
            ->whereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", [Str::slug($name)]) // Cari berdasarkan slug dari name
            ->firstOrFail();

        return inertia('VirtualTours/Detail', [
            'virtualTour' => [
                'id'          => $virtual->id,
                'name'        => $virtual->name,
                'url_embed'   => $virtual->url_embed,
                'description' => $virtual->description,
                'category'    => $virtual->category ? $virtual->category->name : null,
            ],
            'aboutApp' => $aboutApp,
        ]);
    }
}
