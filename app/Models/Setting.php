<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_en',
        'logo_ar',
        'title_en',
        'title_ar',
        'sub_title_en',
        'sub_title_ar',
        'images',
        'color',
    ];

    protected $casts = [
        'images' => 'array',
    ];

   
}
