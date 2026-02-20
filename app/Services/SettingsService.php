<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    private const CACHE_KEY = 'app_settings_all';
    private const CACHE_TTL = 3600;

    public function all(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        Setting::set($key, $value);
        Cache::forget(self::CACHE_KEY);
    }

    public function setMany(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
        Cache::forget(self::CACHE_KEY);
    }

    public function themeVars(): array
    {
        $all = $this->all();
        return [
            'primary_color' => $all['theme_primary_color'] ?? '#2563eb',
            'company_name' => $all['company_name'] ?? config('app.name'),
            'logo' => $all['app_logo'] ?? null,
            'favicon' => $all['favicon'] ?? null,
            'footer_note' => $all['footer_note'] ?? null,
            'delivery_fee' => $all['delivery_fee'] ?? 0,
            // Contact / address
            'address' => $all['company_address'] ?? null,
            'phone' => $all['company_phone'] ?? null,
            'email' => $all['company_email'] ?? null,
            'facebook' => $all['social_facebook'] ?? null,
            'instagram' => $all['social_instagram'] ?? null,
            'twitter' => $all['social_twitter'] ?? null,
        ];
    }
}
