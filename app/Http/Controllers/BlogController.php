<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class blogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        $blogs = Blog::when(
            $title,
            fn($query, $title) => $query->title($title)
        );

        $blogs = match ($filter) {
            'popular_last_month' => $blogs->popularLastMonth(),
            'popular_last_6months' => $blogs->popularLast6Months(),
            'highest_rated_last_month' => $blogs->highestRatedLastMonth(),
            'highest_rated_last_6months' => $blogs->highestRatedLast6Months(),
            default => $blogs->latest()->withAvgRating()->withCommentsCount()
        };

        $cacheKey = 'blogs:' . $filter . ':' . $title;
        $blogs =
            cache()->remember(
                $cacheKey,
                3600,
                fn() =>
                $blogs->get()
            );

        return view('blogs.index', ['blogs' => $blogs]);
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
    public function show(int $id)
    {
        $cacheKey = 'blog:' . $id;

        $blog = cache()->remember(
            $cacheKey,
            3600,
            fn() =>
            Blog::with([
                'comments' => fn($query) => $query->latest()
            ])->withAvgRating()->withCommentsCount()->findOrFail($id)
        );

        return view('blogs.show', ['blog' => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
