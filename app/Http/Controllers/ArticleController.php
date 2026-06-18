<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published();

        if ($request->has('category') && $request->category != 'all') {
            $query->byCategory($request->category);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->latest('published_at')->paginate(9);
        $categories = Article::distinct()->pluck('category');

        return view('articles.index', compact('articles', 'categories'));
    }

   public function show($slug)
{
    // Ambil artikel yang sedang dibuka
    $article = Article::where('slug', $slug)->firstOrFail();

    // Ambil artikel selanjutnya (yang dipublish setelah artikel ini)
    $nextArticle = Article::where('id', '>', $article->id)
                          ->where('published_at', '<=', now())
                          ->orderBy('id', 'asc')
                          ->first();

    return view('articles.show', compact('article', 'nextArticle'));
}
}
