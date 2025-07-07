<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lecturers;
use App\Models\Virtual;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasRole('user')) {
            return $this->dashboardUser();
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function dashboardAdmin()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $oneWeekAgo = Carbon::now()->subWeek();
        $today = Carbon::now();

        $data = [
            // Content Statistics
            'total_articles' => Article::count(),
            'articles_this_month' => Article::where('created_at', '>=', $oneMonthAgo)->count(),
            'articles_this_week' => Article::where('created_at', '>=', $oneWeekAgo)->count(),
            'total_views' => Article::sum('view_count'),
            'popular_articles' => Article::where('created_at', '>=', $oneMonthAgo)
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get(),
            'latest_articles' => Article::orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'articles_by_category' => Category::where('type', 'article')
                ->withCount('articles')
                ->get(),

            // Course Statistics
            'total_courses' => Course::count(),
            'courses_by_concentration' => Course::selectRaw('major_concentration, COUNT(*) as count')
                ->groupBy('major_concentration')
                ->get(),
            'total_credits' => Course::sum('credits'),
            'avg_credits_per_course' => Course::avg('credits'),

            // Lecturer Statistics
            'total_lecturers' => Lecturers::count(),
            'lecturers_with_courses' => Lecturers::has('courses')->count(),
            'lecturers_without_courses' => Lecturers::doesntHave('courses')->count(),
            'top_lecturers' => Lecturers::withCount('courses')
                ->orderBy('courses_count', 'desc')
                ->take(5)
                ->get(),

            // Virtual Tour Statistics
            'total_virtual_tours' => Virtual::count(),
            'virtual_tours_this_month' => Virtual::where('created_at', '>=', $oneMonthAgo)->count(),
            'popular_virtual_categories' => Category::whereHas('virtuals')
                ->withCount('virtuals')
                ->orderBy('virtuals_count', 'desc')
                ->take(5)
                ->get(),

            // User Statistics
            'total_users' => \App\Models\User::count(),
            'users_this_month' => \App\Models\User::where('created_at', '>=', $oneMonthAgo)->count(),

            // Recent Activity
            'recent_activity' => [
                'articles' => Article::orderBy('created_at', 'desc')->take(3)->get(),
                'courses' => Course::orderBy('created_at', 'desc')->take(3)->get(),
                'virtual_tours' => Virtual::orderBy('created_at', 'desc')->take(3)->get(),
            ],

            // Monthly Statistics for Charts
            'monthly_articles' => Article::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $today->year)
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
            'monthly_users' => \App\Models\User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $today->year)
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray(),
        ];

        return view('admin.dashboard', $data);
    }

    public function dashboardUser()
    {
        return view('user.dashboard', [
        ]);
    }

}
