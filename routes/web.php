<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\WhyChooseUs;
use App\Http\Controllers\ReviewController;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;

// Route untuk guest (sebelum login)
Route::get('/', function () {
    $sliders = Slider::where('is_active', true)
        ->orderBy('order')
        ->get();
        
    $reviews = Review::orderBy('created_at', 'desc')
        ->where('rating', '>=', 4)
        ->take(6)
        ->get();

    $categories = Category::withCount('products')
        ->orderBy('name')
        ->get();

    $featuredProducts = Product::where('is_featured', true)
        ->with('category')
        ->latest()
        ->take(6)
        ->get();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'initialSliders' => $sliders,
        'initialReviews' => $reviews,
        'initialCategories' => $categories,
        'initialFeaturedProducts' => $featuredProducts,
    ]);
})->name('welcome');

// Route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    // Halaman Home setelah login (ini akan menjadi default redirect)
    Route::get('/home', function () {
        $sliders = Slider::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        $reviews = Review::orderBy('created_at', 'desc')
            ->where('rating', '>=', 4)
            ->take(6)
            ->get();

        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return Inertia::render('Home', [
            'initialSliders' => $sliders,
            'initialReviews' => $reviews,
            'initialCategories' => $categories,
            'initialFeaturedProducts' => $featuredProducts,
        ]);
    })->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

require __DIR__.'/auth.php';



