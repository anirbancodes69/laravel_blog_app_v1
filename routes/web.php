<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::get('/', function () {
    return redirect()->route('blogs.index');
});

Route::resource('blogs', BlogController::class);

Route::fallback(function () {
    return Response::HTTP_NOT_FOUND;
});
