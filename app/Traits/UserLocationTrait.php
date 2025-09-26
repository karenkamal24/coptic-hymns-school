<?php
namespace App\Traits;

use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Cache;

trait UserLocationTrait
{
    
    public function getUserSettingsByIp(string $ip, ?string $lang = null): array
    {
        $position = Cache::remember("location:$ip", 60*60, function() use ($ip) {
            return Location::get($ip) ?? (object) ['countryCode' => 'US', 'currencyCode' => 'USD'];
        });

        $countryCode = $position->countryCode ?? 'US';

        if (!$lang) {
            $lang = $countryCode === 'EG' ? 'ar' : 'en';
        }

        return [$countryCode, $lang];
    }
}
