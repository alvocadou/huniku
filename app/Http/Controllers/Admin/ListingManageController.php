<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingManageController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::query()
            ->with(['images', 'submittedBy'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
            })
            ->when($request->filled('status') && $request->input('status') !== 'semua', function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.listings.index', [
            'listings' => $listings,
            'q' => $request->input('q', ''),
            'statusFilter' => $request->input('status', 'semua'),
            'pendingCount' => Listing::where('status', 'pending')->count(),
        ]);
    }

    public function approve(Listing $listing)
    {
        $listing->update(['status' => 'approved', 'rejection_reason' => null]);

        return back()->with('status', 'Listing "' . $listing->title . '" disetujui dan sekarang tayang.');
    }

    public function reject(Request $request, Listing $listing)
    {
        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $listing->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        return back()->with('status', 'Listing "' . $listing->title . '" ditolak.');
    }

    public function create()
    {
        return view('admin.listings.form', [
            'listing' => new Listing(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        $data['status'] = 'approved'; // listing yang ditambah admin langsung tayang, nggak perlu review

        $listing = Listing::create($data);

        $this->storeImages($request, $listing);

        return redirect()->route('admin.listings.index')
            ->with('status', 'Listing berhasil ditambahkan.')
            ->with('form_alert', 'Listing berhasil ditambahkan!');
    }

    public function edit(Listing $listing)
    {
        $listing->load('images');

        return view('admin.listings.form', compact('listing'));
    }

    public function update(Request $request, Listing $listing)
    {
        $data = $this->validated($request);

        if ($listing->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']) . '-' . Str::random(4);
        }

        $listing->update($data);

        // Hapus gambar yang dicentang buat dihapus
        if ($request->filled('delete_images')) {
            $imagesToDelete = ListingImage::where('listing_id', $listing->id)
                ->whereIn('id', $request->input('delete_images'))
                ->get();

            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        $this->storeImages($request, $listing);

        return redirect()->route('admin.listings.index')
            ->with('status', 'Listing berhasil diupdate.')
            ->with('form_alert', 'Listing berhasil diupdate!');
    }

    public function destroy(Listing $listing)
    {
        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $listing->delete();

        return redirect()->route('admin.listings.index')->with('status', 'Listing berhasil dihapus.');
    }

    private function storeImages(Request $request, Listing $listing): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $startOrder = $listing->images()->max('sort_order') + 1;
        $failedCount = 0;

        foreach ($request->file('images') as $index => $file) {
            if (! $file->isValid()) {
                $failedCount++;
                continue; // file ini gagal terupload (biasanya kelebihan ukuran dari batas php.ini)
            }

            $path = $file->store('listings', 'public');

            ListingImage::create([
                'listing_id' => $listing->id,
                'path' => $path,
                'sort_order' => $startOrder + $index,
            ]);
        }

        if ($failedCount > 0) {
            session()->flash('upload_warning', "{$failedCount} foto gagal diupload — kemungkinan ukurannya melebihi batas upload_max_filesize di php.ini server kamu.");
        }
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
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
            'thumbnail_color' => ['required', 'in:teal,clay,dark'],
            'is_verified' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'max:4096'], // max 4MB per gambar
        ]);

        $validated['is_verified'] = $request->boolean('is_verified');
        $validated['is_featured'] = $request->boolean('is_featured');
        unset($validated['images']);

        return $validated;
    }
}