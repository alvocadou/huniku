<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'transaction_type',
        'city',
        'district',
        'latitude',
        'longitude',
        'price',
        'price_unit',
        'description',
        'thumbnail_color',
        'is_verified',
        'is_featured',
        'status',
        'submitted_by',
        'rejection_reason',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'integer',
    ];

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    public function firstImageUrl(): ?string
    {
        $first = $this->images->first();

        return $first ? $first->url() : null;
    }

    // Format harga jadi "Rp 950rb" / "Rp 4,2jt"
    public function formattedPrice(): string
    {
        if ($this->price >= 1_000_000) {
            return 'Rp ' . rtrim(rtrim(number_format($this->price / 1_000_000, 1, ',', '.'), '0'), ',') . 'jt';
        }

        return 'Rp ' . number_format($this->price / 1000, 0, ',', '.') . 'rb';
    }

    public function unitLabel(): string
    {
        return match ($this->price_unit) {
            'bulan' => '/bulan',
            'tahun' => '/tahun',
            'hari' => '/hari',
            'jual' => '',
            default => '',
        };
    }

    public function isForSale(): bool
    {
        return $this->transaction_type === 'jual';
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    // URL embed peta — pakai koordinat kalau ada, kalau nggak fallback ke pencarian alamat teks
    public function mapEmbedUrl(): string
    {
        if ($this->hasCoordinates()) {
            $query = $this->latitude . ',' . $this->longitude;
        } else {
            $query = trim($this->district . ' ' . $this->city . ' Indonesia');
        }

        return 'https://maps.google.com/maps?q=' . urlencode($query) . '&z=15&output=embed';
    }

    public function mapLinkUrl(): string
    {
        if ($this->hasCoordinates()) {
            return 'https://www.google.com/maps?q=' . $this->latitude . ',' . $this->longitude;
        }

        $query = trim($this->district . ' ' . $this->city . ' Indonesia');

        return 'https://www.google.com/maps/search/' . urlencode($query);
    }
}