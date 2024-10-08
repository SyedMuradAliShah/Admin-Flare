<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Accessor for getting the site logo.
     */
    public function getLogoAttribute(): ?string
    {
        $logoSetting = $this->where('key', 'site_general_logo')->first();

        return $logoSetting ? $logoSetting->value : null;
    }

    /**
     * Accessor for getting the site logo.
     */
    public function getFaviconAttribute(): ?string
    {
        $logoSetting = $this->where('key', 'site_general_favicon')->first();

        return $logoSetting ? $logoSetting->value : null;
    }

    /**
     * Accessor for getting general settings.
     */
    public function getGeneralAttribute()
    {
        return $this->where('key', 'like', 'site_general_%')
            ->whereNotIn('key', ['site_general_logo', 'site_general_favicon'])
            ->orderBy('id')
            ->get();
    }

    /**
     * Accessor for getting social settings.
     */
    public function getSocialLinksAttribute()
    {
        return $this->where('key', 'like', 'site_social_%')
            ->orderBy('id')
            ->get();
    }
}
