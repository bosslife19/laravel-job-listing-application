<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

Route::get('/', [ListingController::class, 'index']);



// Show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');


Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');;



// show edit form

Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');



// update lisiting
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');;

// delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');;


// manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
Route::get("/listings/{listing}", [ListingController::class, 'show']);

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// create user

Route::post('/users', [UserController::class, 'store']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');;

// show login form

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');;
Route::post('/users/login', [UserController::class, 'authenticate']);



