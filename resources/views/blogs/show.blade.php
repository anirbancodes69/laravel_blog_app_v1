@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="sticky top-0 mb-2 text-2xl">{{ $blog->title }}</h1>

    <div class="book-info">
        <div class="book-author mb-4 text-lg font-semibold">by Anirban</div>
        <div class="book-rating flex items-center">
            <div class="mr-2 text-sm font-medium text-slate-700">
                <x-star-rating :rating="$blog->comments_avg_rating" />
            </div>
            <span class="book-review-count text-sm text-gray-500">
                {{ $blog->comments_count }} {{ Str::plural('comment', $blog->comments_count) }}
            </span>
        </div>
    </div>
</div>

<div>
    <h2 class="mb-4 text-xl font-semibold">Comments</h2>
    <ul>
        @forelse ($blog->comments as $comment)
        <li class="book-item mb-4">
            <div>
                <div class="mb-2 flex items-center justify-between">
                    <div class="font-semibold">
                        <x-star-rating :rating="$comment->rating" />
                    </div>

                    <div class="book-review-count">
                        {{ $comment->created_at->format('M j, Y') }}</div>
                </div>
                <p class="text-gray-700">{{ $comment->comment }}</p>
            </div>
        </li>
        @empty
        <li class="mb-4">
            <div class="empty-book-item">
                <p class="empty-text text-lg font-semibold">No comments yet</p>
            </div>
        </li>
        @endforelse
    </ul>
</div>
@endsection