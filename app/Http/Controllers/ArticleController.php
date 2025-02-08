<?php

namespace App\Http\Controllers;

use App\Helpers\MediaLibrary;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active');

        $query  = Article::with('category')->whereHas('category', function ($query) {
            $query->where('type', 'article');
        });
        if ($request->has('name')) {
            $query->where('name', $request->query('name'));
        }

        if ($filter == 'trashed') {
            $query->onlyTrashed();
        } elseif ($filter == 'all') {
            $query->withTrashed();
        }

        $articles = $query->get();

        return view('menu.articles.index', compact('articles', 'filter'));
    }

    public function create()
    {
        $categories = Category::where('type', 'article')->get();
        return view('menu.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:255',
            'content'     => 'required',
            'tags'        => 'array',
            'article-images' => 'array|max:5',
        ]);

        $article = Article::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'slug'        => Str::slug($request->title),
            'tags'        => $request->tags,

        ]);

        if ($request->has('article-images')) {
            MediaLibrary::put(
                $article,
                'article-images',
                $request,
                'article-images'
            );
        }

        return redirect()->route('articles.index')->with('success', 'Article added successfully.');
    }

    public function edit(Article $article)
    {
        $categories = Category::where('type', 'article')->get();
        $articleImages = $article->getMedia('article-images');
        return view('menu.articles.edit', compact('article', 'categories', 'articleImages'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:255',
            'content'     => 'required',
            'tags'        => 'array',
            'article-images' => 'array|max:5',
        ]);



        if ($request->has('article-images')) {
            MediaLibrary::put(
                $article,
                'article-images',
                $request,
                'article-images'
            );
        }

        $article->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'slug'        => Str::slug($request->title),
            'tags'        => $request->tags,
        ]);
        
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    public function trashed()
    {
        $articles = Article::onlyTrashed()->with('category')->get();
        return view('menu.articles.trashed', compact('articles'));
    }

    public function restore($id)
    {
        Article::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('articles.index')->with('success', 'Article restored successfully.');
    }

    public function forceDelete($id)
    {
        Article::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('articles.index')->with('success', 'Article permanently deleted.');
    }
}
