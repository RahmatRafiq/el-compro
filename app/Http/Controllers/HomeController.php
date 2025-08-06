<?php
namespace App\Http\Controllers;

use App\Models\AboutApp;
use App\Models\Article;
use App\Models\Category;
use App\Models\Course;
use App\Models\GeneralInformation;
use App\Models\GraduateLearningOutcome;
use App\Models\Lecturers;
use App\Models\Virtual;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    protected $aboutApp;

    public function __construct()
    {
        $this->aboutApp = Cache::remember('aboutApp', now()->addMinutes(60), function () {
            return AboutApp::first();
        });
    }

    public function show($slug)
    {
        $article = Article::with('media')->where('slug', $slug)->firstOrFail();
        $article->increment('view_count');

        $popularArticles = Cache::remember("popular_articles", now()->addMinutes(10), function () {
            return Article::with('media')
                ->where('created_at', '>=', now()->subMonth())
                ->orderByDesc('view_count')
                ->take(5)
                ->get(['id', 'slug', 'title', 'view_count', 'created_at'])
                ->map(function ($article) {
                    $article->image = $article->getFirstMediaUrl('article-image') ?: null;
                    return $article;
                });
        });

        $latestArticles = Cache::remember("latest_articles", now()->addMinutes(10), function () {
            return Article::with('media')
                ->orderByDesc('created_at')
                ->take(5)
                ->get(['id', 'slug', 'title', 'created_at'])
                ->map(function ($article) {
                    $article->image = $article->getFirstMediaUrl('article-image') ?: null;
                    return $article;
                });
        });

        return inertia('Articles/ArticleDetail', [
            'article' => [
                'slug' => $article->slug,
                'id' => $article->id,
                'title' => $article->title,
                'content' => $article->content,
                'image' => $article->getFirstMediaUrl('article-image') ?: null,
                'view_count' => $article->view_count + 1,
                'created_at' => $article->created_at->format('d M Y'),
            ],
            'popularArticles' => $popularArticles,
            'latestArticles' => $latestArticles,
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function articlesByCategory($name)
    {
        $category = Cache::remember("category_article_{$name}", now()->addMinutes(60), function () use ($name) {
            return Category::where('name', $name)
                ->where('type', 'article')
                ->firstOrFail();
        });

        $articles = Article::where('category_id', $category->id)
            ->latest()
            ->paginate(10)
            ->through(fn($article) => [
                'id' => $article->id,
                'title' => $article->title,
                'image' => $article->getFirstMediaUrl('article-image') ?: asset('images/default-article.png'),
                'view_count' => $article->view_count,
                'slug' => $article->slug,
            ]);

        return inertia('Articles/CategoryArticles', [
            'category' => [
                'name' => $category->name,
            ],
            'articles' => $articles,
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function index()
    {
        $articles = Cache::remember("home_articles", now()->addMinutes(10), function () {
            return Article::latest()->take(5)->get()->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'image' => $article->getFirstMediaUrl('article-image') ?: asset('images/default-article.png'),
                    'view_count' => $article->view_count,
                    'slug' => $article->slug,
                ];
            });
        });

        $courses = Cache::remember("home_courses", now()->addMinutes(10), function () {
            return Course::get();
        });

        $lecturers = Cache::remember("home_lecturers", now()->addMinutes(10), function () {
            return Lecturers::with('courses')->take(2)->get()->map(function ($lecturer) {
                return [
                    'id' => $lecturer->id,
                    'name' => $lecturer->name,
                    'about' => $lecturer->about,
                    'image' => $lecturer->getFirstMediaUrl('lecturer-image') ?: asset('images/default-avatar.png'),
                    'courses' => $lecturer->courses->map(fn($course) => [
                        'id' => $course->id,
                        'name' => $course->name,
                    ]),
                ];
            });
        });

        $virtualTours = Cache::remember("home_virtualTours", now()->addMinutes(10), function () {
            return Virtual::with('category')
                ->whereHas('category', function ($query) {
                    $query->where('type', 'virtual_tours');
                })
                ->get();
        });

        $concentrationData = Cache::remember("home_concentrationData", now()->addMinutes(10), function () {
            return GeneralInformation::where('type', 'Konsentrasi')
                ->select('id', 'name', 'description')
                ->get();
        });

        $generalInformationData = Cache::remember("home_generalInformationData", now()->addMinutes(10), function () {
            return GeneralInformation::whereIn('name', [
                'Keunggulan',
                'Capaian Prestasi',
                'Prospek Karier',
                'Informasi dan Alur Pendaftaran',
            ])->get();
        });

        return inertia('Home', [
            'courses' => $courses,
            'articles' => $articles,
            'aboutApp' => $this->aboutApp,
            'lecturers' => $lecturers,
            'virtualTours' => $virtualTours,
            'concentrationData' => $concentrationData,
            'generalInformationData' => $generalInformationData,
        ]);
    }

    public function lecturers()
    {
        $lecturers = Cache::remember("lecturers_all", now()->addMinutes(10), function () {
            return Lecturers::with('courses')->get()->map(fn($lecturer) => [
                'id' => $lecturer->id,
                'name' => $lecturer->name,
                'about' => $lecturer->about,
                'email' => $lecturer->email,
                'image' => $lecturer->getFirstMediaUrl('lecturer-image') ?: asset('images/default-avatar.png'),
                'courses' => $lecturer->courses->map(fn($course) => [
                    'id' => $course->id,
                    'name' => $course->name,
                ]),
            ]);
        });

        return inertia('Lecturers', [
            'lecturers' => $lecturers,
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function courses()
    {
        $courses = Cache::remember("courses_all", now()->addMinutes(10), function () {
            return Course::with('lecturers')->get();
        });

        $graduateLearningOutcomes = Cache::remember("cpl_all", now()->addMinutes(10), function () {
            return GraduateLearningOutcome::select('id', 'concentration', 'name', 'description')->get();
        });

        return inertia('Courses', [
            'courses' => $courses,
            'graduateLearningOutcomes' => $graduateLearningOutcomes,
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function articles()
    {
        $categories = Cache::remember("article_categories", now()->addMinutes(10), function () {
            return Category::where('type', 'article')->get();
        });

        $categoriesWithArticles = $categories->map(function ($category) {
            $articles = Article::where('category_id', $category->id)
                ->latest()
                ->take(4)
                ->get()
                ->map(fn($article) => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'image' => $article->hasMedia('article-image') ? $article->getFirstMediaUrl('article-image') : null,
                    'view_count' => $article->view_count,
                    'slug' => $article->slug,
                ]);
            return [
                'name' => $category->name,
                'articles' => $articles,
            ];
        });

        return inertia('Articles', [
            'categories' => $categoriesWithArticles,
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function virtualTours()
    {
        // Clear the cache to ensure fresh data
        Cache::forget("virtualTours_all");

        $virtualTours = Cache::remember("virtualTours_all", now()->addMinutes(10), function () {
            return Virtual::with('category')
                ->whereHas('category', function ($query) {
                    $query->where('type', 'virtual_tours');
                })
                ->get()
                ->map(function ($virtual) {
                    // Ensure each virtual tour has a slug
                    if (empty($virtual->slug)) {
                        $virtual->slug = Str::slug($virtual->name);
                        $virtual->save();
                    }

                    return [
                        'id' => $virtual->id,
                        'name' => $virtual->name,
                        'slug' => $virtual->slug,
                        'url_embed' => $virtual->url_embed,
                        'description' => $virtual->description,
                        'category' => $virtual->category ? $virtual->category->name : null,
                    ];
                });
        });

        return inertia('VirtualTours', [
            'virtualTours' => $virtualTours,
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function virtualTourDetail($slug)
    {
        // Add detailed debugging
        \Log::info('Virtual Tour Detail Request', [
            'original_slug' => $slug,
            'decoded_slug' => urldecode($slug)
        ]);

        // For troubleshooting, let's find all virtual tours
        $allVirtuals = Virtual::all();
        \Log::info('All Virtual Tours', [
            'count' => $allVirtuals->count(),
            'data' => $allVirtuals->pluck('name', 'slug')->toArray()
        ]);

        // Try to decode the URL in case it's URL-encoded
        $decodedSlug = urldecode($slug);

        // First try with the exact slug
        $virtual = Virtual::with('category')
            ->where('slug', $decodedSlug)
            ->first();

        // If not found, try with regenerated slug (in case DB has different slug format)
        if (!$virtual) {
            $virtual = Virtual::with('category')
                ->whereRaw('LOWER(slug) = ?', [strtolower($decodedSlug)])
                ->first();
        }

        // If still not found, try with the name directly
        if (!$virtual) {
            $virtual = Virtual::with('category')
                ->whereRaw('LOWER(REPLACE(name, " ", "-")) = ?', [strtolower($decodedSlug)])
                ->first();
        }

        // If still not found, try a looser match
        if (!$virtual) {
            $virtual = Virtual::with('category')
                ->whereRaw('slug LIKE ?', ['%' . str_replace('-', '%', $decodedSlug) . '%'])
                ->first();
        }

        // If still not found, throw 404 with details
        if (!$virtual) {
            \Log::warning('Virtual Tour Not Found', [
                'attempted_slug' => $decodedSlug,
                'available_slugs' => Virtual::pluck('slug')->toArray()
            ]);
            abort(404, 'Virtual tour not found');
        }

        // Log successful match
        \Log::info('Virtual Tour Found', [
            'id' => $virtual->id,
            'name' => $virtual->name,
            'slug' => $virtual->slug
        ]);

        return inertia('VirtualTours/Detail', [
            'virtualTour' => [
                'id' => $virtual->id,
                'name' => $virtual->name,
                'url_embed' => $virtual->url_embed,
                'description' => $virtual->description,
                'category' => $virtual->category ? $virtual->category->name : null,
                'slug' => $virtual->slug,
            ],
            'aboutApp' => $this->aboutApp,
        ]);
    }

    public function aboutApp()
    {
        $aboutApp = Cache::remember('aboutApp', now()->addMinutes(10), function () {
            return AboutApp::with('media')->first();
        });

        if ($aboutApp) {
            $aboutApp->image = $aboutApp->hasMedia('struktur-organisasi')
                ? $aboutApp->getFirstMediaUrl('struktur-organisasi')
                : null;
        }

        return inertia('AboutApp', [
            'aboutApp' => $aboutApp,
        ]);
    }
    public function cpl()
    {
        $graduateLearningOutcomes = GraduateLearningOutcome::select('id', 'concentration', 'name', 'description')->get();
        return inertia('CPL', [
            'graduateLearningOutcomes' => $graduateLearningOutcomes,
            'aboutApp' => $this->aboutApp,
        ]);
    }

}
