<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'user_type',
        'company_name',
        'phone',
        'whatsapp',
        'instagram',
        'developer_status',
        'developer_rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteListings()
    {
        return $this->belongsToMany(Listing::class, 'favorites')->withTimestamps();
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'submitted_by');
    }

    public function isDeveloper(): bool
    {
        return $this->user_type === 'developer';
    }

    public function isVerifiedDeveloper(): bool
    {
        return $this->isDeveloper() && $this->developer_status === 'verified';
    }

    public function isPendingDeveloper(): bool
    {
        return $this->isDeveloper() && $this->developer_status === 'pending';
    }

    public function isRejectedDeveloper(): bool
    {
        return $this->isDeveloper() && $this->developer_status === 'rejected';
    }
}