<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::get('/', function () {
    return redirect()->route('blogs.index');
});

Route::resource('blogs', BlogController::class)->only(['index', 'show']);

Route::resource('blogs.comments', CommentController::class)
    ->scoped(['comment' => 'book'])
    ->only(['create', 'store'])
    ->middleware([
        'store' => 'throttle:5,1'
    ]);


Route::fallback(function () {
    return Response::HTTP_NOT_FOUND;
});
