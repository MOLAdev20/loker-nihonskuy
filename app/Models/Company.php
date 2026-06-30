<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        'name',
        'logo',
        'bio',
        'location',
        'website',
        'field',
        'facility',
        'established',
    ];

    public function getLogoUrlAttribute(): string
    {
        if (! $this->logo) {
            return '';
        }

        if (Str::startsWith($this->logo, ['http://', 'https://'])) {
            return $this->logo;
        }

        $normalizedPath = ltrim($this->logo, '/');

        if (File::exists(public_path($normalizedPath))) {
            return asset($normalizedPath);
        }

        if (Storage::disk('public')->exists($normalizedPath)) {
            return route('company.logo', $this);
        }

        return '';
    }

    public function getWebsiteHrefAttribute(): string
    {
        $website = trim((string) $this->website);

        if ($website === '') {
            return '#';
        }

        if (Str::startsWith($website, ['http://', 'https://'])) {
            return $website;
        }

        return 'https://' . ltrim($website, '/');
    }

    public function getFacilityItemsAttribute(): array
    {
        return collect(preg_split('/[\r\n,;]+/', (string) $this->facility) ?: [])
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    public function getInitialsAttribute(): string
    {
        return collect(preg_split('/\s+/', trim((string) $this->name)) ?: [])
            ->filter()
            ->take(2)
            ->map(fn ($word) => Str::upper(Str::substr($word, 0, 1)))
            ->implode('');
    }

    public function getPublicSlugAttribute(): string
    {
        return $this->id . '-' . Str::slug($this->name);
    }
}
