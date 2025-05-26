@extends('layouts.app')

@section('content')
<h1 class="mb-10 text-2xl">Blogs</h1>

<form method="GET" action="{{ route('blogs.index') }}" class="mb-4 flex items-center space-x-2">
    <input type="text" name="title" placeholder="Seacrh by title" value="{{ request('title') }}" class="input h-10">
    <input type="hidden" name="filter" value="{{ request('filter') }}">
    <button type="submit" class="btn h-10">Search</button>
    <a href="{{ route('blogs.index') }}" class="btn h-10">Clear</a>
</form>

<div class="filter-container mb-4 flex">
    @php
    $filters = [
    '' => 'Latest',
    'popular_last_month' => 'Popular Last Month',
    'popular_last_6_month' => 'Popular Last 6 Month',
    'highest_rated_last_month' => 'Highest Rated Last Month',
    'highest_rated_last_6_month' => 'Highest Rated Last 6 Month',
    ]
    @endphp

    @foreach ($filters as $key => $label)
    <a href="{{route('blogs.index', [...request()->query(), 'filter' => $key])}}"
        class="{{ $key === request('filter') || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">{{$label}}</a>
    @endforeach
</div>

<ul>
    @forelse ($blogs as $blog)
    <li class="mb-4">
        <div class="book-item">
            <div class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                    <a href="{{ route('blogs.show', $blog) }}" class="book-title">{{$blog->title}}</a>
                    <span class="book-author">by Anirban</span>
                </div>
                <div>
                    <div class="book-rating">
                        <x-star-rating :rating="$blog->comments_avg_rating" />
                    </div>
                    <div class="book-review-count">
                        out of {{ $blog->comments_count }} {{ Str::plural('comment', $blog->comments_count) }}
                    </div>
                </div>
            </div>
        </div>
    </li>
    @empty
    <li class="mb-4">
        <div class="empty-book-item">
            <p class="empty-text">No blogs found</p>
            <a href="{{ route('blogs.index') }}" class="reset-link">Reset criteria</a>
        </div>
    </li>
    @endforelse
</ul>
@endsection