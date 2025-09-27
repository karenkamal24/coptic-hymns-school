<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class SettingService
{
    protected ?Setting $setting;

    public function __construct()
    {
        $this->setting = Setting::first();
    }

    public function getInformation(Request $request): array
    {
        if (!$this->setting) {
            return [];
        }

        $lang = strtolower($request->header('Accept-Language', ''));

        if (!in_array($lang, ['en', 'ar'])) {
            $ip = $request->ip();
            $position = Location::get($ip);

            $lang = ($position && $position->countryCode === 'EG') ? 'ar' : 'en';
        }

        // Handle images field (JSON string or array)
        $images = $this->setting->images;
        if (is_string($images)) {
            $images = json_decode($images, true) ?? [];
        } elseif (!is_array($images)) {
            $images = [];
        }

        return [
            'logo' => $lang === 'ar' ? $this->setting->logo_ar : $this->setting->logo_en,
            'title' => $lang === 'ar' ? $this->setting->title_ar : $this->setting->title_en,
            'sub_title' => $lang === 'ar' ? $this->setting->sub_title_ar : $this->setting->sub_title_en,
            'images' => collect($images)
                ->map(function ($item) {
                    // Assuming each item in images has an 'image' key
                    return isset($item['image']) ? asset('storage/' . $item['image']) : null;
                })
                ->filter() // Remove null values
                ->values()
                ->toArray(),
        ];
    }


    public function getColor(): ?string
    {
        return $this->setting?->color;
    }
}
