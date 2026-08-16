<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::query()->with('images')->approved();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('city', 'like', "%{$search}%")
                  ->orWhere('district', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type') && $request->input('type') !== 'semua') {
            $query->where('type', $request->input('type'));
        }

        $mode = $request->input('mode', 'sewa');
        if (in_array($mode, ['sewa', 'jual'])) {
            $query->where('transaction_type', $mode);
        }

        if ($mode === 'sewa' && $request->filled('duration') && $request->input('duration') !== 'semua') {
            $query->where('price_unit', $request->input('duration'));
        }

        if ($mode === 'jual' && $request->filled('price_range')) {
            match ($request->input('price_range')) {
                'under_300' => $query->where('price', '<', 300_000_000),
                '300_1000' => $query->whereBetween('price', [300_000_000, 1_000_000_000]),
                'over_1000' => $query->where('price', '>', 1_000_000_000),
                default => null,
            };
        }

        $listings = $query->latest()->paginate(9)->withQueryString();

        $favoritedIds = auth()->check()
            ? auth()->user()->favorites()->pluck('listing_id')->toArray()
            : [];

        return view('listings.index', [
            'listings' => $listings,
            'favoritedIds' => $favoritedIds,
            'filters' => [
                'q' => $request->input('q', ''),
                'type' => $request->input('type', 'semua'),
                'mode' => $mode,
                'duration' => $request->input('duration', 'semua'),
                'price_range' => $request->input('price_range', 'semua'),
            ],
        ]);
    }

    public function show(Listing $listing)
    {
        if (! $listing->isApproved()) {
            $isOwner = auth()->check() && $listing->submitted_by === auth()->id();
            $isAdmin = auth()->check() && auth()->user()->is_admin;

            if (! $isOwner && ! $isAdmin) {
                abort(404);
            }
        }

        $listing->load('images');

        // catat ke riwayat "baru dilihat" (session, maks 8 item terbaru)
        $viewed = session('recently_viewed', []);
        $viewed = array_values(array_filter($viewed, fn ($id) => $id != $listing->id));
        array_unshift($viewed, $listing->id);
        session(['recently_viewed' => array_slice($viewed, 0, 8)]);

        $related = Listing::with('images')
            ->where('type', $listing->type)
            ->where('id', '!=', $listing->id)
            ->take(3)
            ->get();

        $isFavorited = auth()->check()
            ? auth()->user()->favorites()->where('listing_id', $listing->id)->exists()
            : false;

        $favoritedIds = auth()->check()
            ? auth()->user()->favorites()->pluck('listing_id')->toArray()
            : [];

        return view('listings.show', [
            'listing' => $listing,
            'related' => $related,
            'isFavorited' => $isFavorited,
            'favoritedIds' => $favoritedIds,
        ]);
    }
}