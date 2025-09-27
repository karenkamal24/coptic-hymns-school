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

        return [
            'logo' => $lang === 'ar' ? $this->setting->logo_ar : $this->setting->logo_en,
            'title' => $lang === 'ar' ? $this->setting->title_ar : $this->setting->title_en,
            'sub_title' => $lang === 'ar' ? $this->setting->sub_title_ar : $this->setting->sub_title_en,
            'images' => collect($this->setting->images)
                ->map(fn($image) => asset('storage/' . $image))
                ->toArray(),


        ];
    }



    public function getColor(): ?string
    {
        return $this->setting?->color;
    }
}
