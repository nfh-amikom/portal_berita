<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category; // Import the Category model
use App\Models\NewsViewLog; // Import the NewsViewLog model
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->input('category');

        $query = News::with(['author', 'category'])->latest();

        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('id', $selectedCategory);
            });
        }

        $news = $query->get();
        $headline = $news->first();
        $other_news = $news->skip(1);

        return view('news', compact('headline', 'other_news', 'categories', 'selectedCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        $news->increment('views'); // Increment the views count

        // Log the view event
        NewsViewLog::create([
            'news_id' => $news->id,
            'viewed_at' => now(),
        ]);

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
