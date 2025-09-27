<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;


    protected $fillable = [
        'full_name_en',
        'full_name_ar',
        'specialty_en',
        'specialty_ar',
        'description_en',
        'description_ar',
        'experience',
        'images',
        'contacts',
    ];


    protected $casts = [
        'images' => 'array',
        'contacts' => 'array',
    ];

public function courses()
{
    return $this->hasMany(Course::class, 'instructor_id');
    // افترض إن جدول courses فيه عمود instructor_id يربط الكورس بالمدرب
}

}
