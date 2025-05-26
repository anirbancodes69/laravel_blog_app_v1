@extends('layouts.app')

@section('content')
<h1 class="mb-10 text-2xl">Add Comment for {{ $blog->title }}</h1>

<form action="{{route('blogs.comments.store', $blog)}}" method="POST">
    @csrf
    <label for="comment">Comment</label>
    <textarea name="comment" id="comment" required class="input mb-4"></textarea>
    <label for="rating">Rating</label>
    <select name="rating" id="rating" class="mb-4 input" required>
        <option value="">Select a Rating</option>
        @for ($i = 1; $i <= 5; $i++) <option value="{{$i}}">{{$i}}
            </option>
            @endfor
    </select>
    <button type="submit" class="btn">Add Comment</button>
</form>
@endsection