<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
protected $fillable = [
    'course_id', 'name', 'email', 'phone', 'status', 'receipt_image'
];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function booted()
    {

        static::created(function ($enrollment) {
            $enrollment->course()->increment('enrollments_count');
        });


        static::deleted(function ($enrollment) {
            $enrollment->course()->decrement('enrollments_count');
        });
    }
}

