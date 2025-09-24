<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'price_usd',
        'price_egp',
        'videos',
        'instructor',
        'rate',
        'duration_by_weak',
    ];

    protected $casts = [
        'videos' => 'array',
        'price_usd' => 'decimal:2',
        'price_egp' => 'decimal:2',
        'rate' => 'decimal:2',
    ];




    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }


    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }


    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }
//     public function reviews()
// {
//     return $this->hasMany(CourseReview::class);
// }

}
