<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;
use App\Models\Enrollment;

class CoursesStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Courses', Course::count())
                ->color('primary')
                ->icon('heroicon-o-book-open'),

            Stat::make('Total Enrollments', Enrollment::count())
                ->color('secondary')
                ->icon('heroicon-o-user-group'),

            Stat::make(' Enrollments Waiting Verification', Enrollment::where('status', 'waiting_verification')->count())
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Stat::make(' Enrollments Confirmed', Enrollment::where('status', 'confirmed')->count())
                ->color('success')
                ->icon('heroicon-o-check-circle'), 
        ];
    }
}
