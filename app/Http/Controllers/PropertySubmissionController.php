<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertySubmissionController extends Controller
{
    public function create()
    {
        if (! auth()->user()->isVerifiedDeveloper()) {
            return view('submit.blocked');
        }

        return view('submit.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->isVerifiedDeveloper(), 403, 'Cuma developer terverifikasi yang bisa daftarkan properti.');

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:rumah,kost,kontrakan,apartemen'],
            'transaction_type' => ['required', 'in:sewa,jual'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'price' => ['required', 'integer', 'min:0'],
            'price_unit' => ['required', 'in:bulan,tahun,hari,jual'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'max:4096'],
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        $data['thumbnail_color'] = collect(['teal', 'clay', 'dark'])->random();
        $data['status'] = 'pending';
        $data['submitted_by'] = auth()->id();
        unset($data['images']);

        $listing = Listing::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                if (! $file->isValid()) {
                    continue;
                }

                ListingImage::create([
                    'listing_id' => $listing->id,
                    'path' => $file->store('listings', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('submit.index')
            ->with('status', 'Listing kamu udah dikirim dan lagi ditinjau tim Huniku. Biasanya diproses 1x24 jam.');
    }

    public function index()
    {
        $listings = Listing::with('images')
            ->where('submitted_by', auth()->id())
            ->latest()
            ->paginate(9);

        return view('submit.index', [
            'listings' => $listings,
        ]);
    }
}