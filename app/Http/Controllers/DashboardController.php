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

        $data = [
            'total_articles'             => Article::count(),
            'popular_articles'           => Article::where('created_at', '>=', $oneMonthAgo)
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get(),
            'articles_by_category'       => Category::where('type', 'article')
                ->withCount('articles')
                ->get(),

            'total_courses'              => Course::count(),
            'total_lecturers'            => Lecturers::count(),
            'top_lecturers'              => Lecturers::withCount('courses')
                ->orderBy('courses_count', 'desc')
                ->take(5)
                ->get(),

            'total_virtual_tours'        => Virtual::count(),
            'popular_virtual_categories' => Category::whereHas('virtuals')
                ->withCount('virtuals')
                ->orderBy('virtuals_count', 'desc')
                ->take(5)
                ->get(),
        ];
        return view('admin.dashboard', $data);
    }

    public function dashboardUser()
    {
        return view('user.dashboard', [
        ]);
    }

}
