@extends('layouts.app')

@section('content')
<h1 class="mb-10 text-2xl">Blogs</h1>

<form method="GET" action="{{ route('blogs.index') }}" class="mb-4 flex items-center space-x-2">
    <input type="text" name="title" placeholder="Seacrh by title" value="{{ request('title') }}" class="input h-10">
    <button type="submit" class="btn h-10">Search</button>
    <a href="{{ route('blogs.index') }}" class="btn h-10">Clear</a>
</form>



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
                        {{ number_format($blog->comments_avg_rating, 1) }}
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