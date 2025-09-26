<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist; // Correct import
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Actions\EditAction; // Correct import

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseResource::class;

    // Header actions
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    // Infolist
    public function infolist(Infolist $infolist): Infolist // Correct type hint
    {
        $record = $this->record;

        return $infolist->schema([
            // Course Info
            Section::make('Course Info')
                ->schema([
                    TextEntry::make('title_en')
                        ->label('Title (EN)')
                        ->getStateUsing(fn() => $record->title_en),
                    TextEntry::make('title_ar')
                        ->label('Title (AR)')
                        ->getStateUsing(fn() => $record->title_ar),
                    TextEntry::make('description_en')
                        ->label('Description (EN)')
                        ->getStateUsing(fn() => $record->description_en),
                    TextEntry::make('description_ar')
                        ->label('Description (AR)')
                        ->getStateUsing(fn() => $record->description_ar),
                    TextEntry::make('instructor')
                        ->label('Instructor')
                        ->getStateUsing(fn() => $record->instructor),
                    TextEntry::make('duration_by_weak')
                        ->label('Duration per Week (hours)')
                        ->getStateUsing(fn() => $record->duration_by_weak),
                    TextEntry::make('price_usd')
                        ->label('Price (USD)')
                        ->getStateUsing(fn() => $record->price_usd),
                    TextEntry::make('price_egp')
                        ->label('Price (EGP)')
                        ->getStateUsing(fn() => $record->price_egp),
                ])
                ->columns(2),

            // Course Image
            Section::make('Course Image')
                ->schema([
                    ImageEntry::make('image')
                        ->label('Course Image')
                        ->getStateUsing(fn() => $record->image ? asset('storage/' . $record->image) : null),
                ]),

            // Videos as links
            Section::make('Videos')
                ->schema(
                    collect($record->videos ?? [])->map(fn($video, $index) =>
                        TextEntry::make("video_{$index}")
                            ->label($video['title'] ?? "Video {$index}")
                            ->getStateUsing(fn() => $video['url'] ?? null)
                    )->toArray()
                ),
        ]);
    }
}
