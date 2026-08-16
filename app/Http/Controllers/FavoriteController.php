<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Listing;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $listings = auth()->user()
            ->favoriteListings()
            ->with('images')
            ->latest('favorites.created_at')
            ->paginate(9);

        return view('favorites.index', [
            'listings' => $listings,
        ]);
    }

    public function toggle(Request $request, Listing $listing)
    {
        $existing = Favorite::where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'listing_id' => $listing->id,
            ]);
            $favorited = true;
        }

        if ($request->wantsJson()) {
            return response()->json(['favorited' => $favorited]);
        }

        return back()->with('status', $favorited ? 'Ditambahkan ke favorit.' : 'Dihapus dari favorit.');
    }
}