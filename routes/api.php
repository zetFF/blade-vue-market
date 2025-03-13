<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Route;

Route::get('/home-data', function () {
    $whyChooseUs = \App\Models\WhyChooseUs::where('is_active', true)
        ->orderBy('order')
        ->get();
    
    \Log::info('WhyChooseUs data:', ['count' => $whyChooseUs->count(), 'data' => $whyChooseUs->toArray()]);
    
    return response()->json([
        'whyChooseUs' => $whyChooseUs,
        'debug' => [
            'count' => $whyChooseUs->count(),
            'sql' => \App\Models\WhyChooseUs::where('is_active', true)->orderBy('order')->toSql()
        ]
    ]);
});

Route::get('/reviews', function () {
    $reviews = \App\Models\Review::orderBy('created_at', 'desc')
        ->where('rating', '>=', 4)
        ->take(6)
        ->get();
    
    // Debug
    \Log::info('API Reviews:', ['count' => $reviews->count(), 'data' => $reviews->toArray()]);
    
    return response()->json([
        'reviews' => $reviews,
        'debug' => [
            'count' => $reviews->count(),
            'query' => \App\Models\Review::orderBy('created_at', 'desc')
                ->where('rating', '>=', 4)
                ->take(6)
                ->toSql()
        ]
    ]);
}); 

Route::get('/home-data', function () {
    return response()->json([
        'categories' => \App\Models\Category::withCount('products')
            ->orderBy('name')
            ->get(),
        'sliders' => \App\Models\Slider::where('is_active', true)
            ->orderBy('order')
            ->get(),
        'whyChooseUs' => \App\Models\WhyChooseUs::where('is_active', true)
            ->orderBy('order')
            ->get(),
        'featuredProducts' => \App\Models\Product::query()
            ->where('is_featured', true)
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get()
    ]);
});

