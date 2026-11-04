<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'tagline',
        'logo',
        'description',
        'announcement',
        'facilities',
        'phone',
        'address',
        'maps_url',
        'instagram',
        'opening_hours',
        'is_open',
        'category',
        'theme_color',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_open' => 'boolean',
        'facilities' => 'array',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The owner of the store.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Products belonging to the store.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Formatted WhatsApp phone number (starts with 62).
     */
    public function getFormattedPhoneAttribute(): string
    {
        $clean = preg_replace('/[^0-9]/', '', $this->phone);

        if (str_starts_with($clean, '0')) {
            return '62'.substr($clean, 1);
        }

        return $clean;
    }

    /**
     * Resolved full URL for the store logo.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
                return $this->logo;
            }

            return asset('storage/'.$this->logo);
        }

        return null;
    }
}
