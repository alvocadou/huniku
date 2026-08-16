<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class LandingController extends Controller
{
    public function index()
    {
        $featuredListings = Listing::with('images')
            ->approved()
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        $categoryCounts = Listing::approved()
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $favoritedIds = auth()->check()
            ? auth()->user()->favorites()->pluck('listing_id')->toArray()
            : [];

        $recentIds = session('recently_viewed', []);
        $recentlyViewed = collect();
        if (! empty($recentIds)) {
            $recentlyViewed = Listing::with('images')
                ->whereIn('id', $recentIds)
                ->get()
                ->sortBy(fn ($listing) => array_search($listing->id, $recentIds))
                ->values();
        }

        return view('landing', [
            'listings' => $featuredListings,
            'categoryCounts' => $categoryCounts,
            'favoritedIds' => $favoritedIds,
            'recentlyViewed' => $recentlyViewed,
        ]);
    }
}