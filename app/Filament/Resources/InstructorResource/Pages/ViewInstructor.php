<?php

namespace App\Filament\Resources\InstructorResource\Pages;

use App\Filament\Resources\InstructorResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Actions\EditAction;

class ViewInstructor extends ViewRecord
{
    protected static string $resource = InstructorResource::class;

    // Header actions
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    // Infolist
    public function infolist(Infolist $infolist): Infolist
    {
        $record = $this->record;

        return $infolist->schema([
            // Instructor Info
            Section::make('Instructor Info')
                ->schema([
                    TextEntry::make('full_name_en')
                        ->label('Full Name (EN)')
                        ->getStateUsing(fn() => $record->full_name_en),
                    TextEntry::make('full_name_ar')
                        ->label('Full Name (AR)')
                        ->getStateUsing(fn() => $record->full_name_ar),
                    TextEntry::make('specialty_en')
                        ->label('Specialty (EN)')
                        ->getStateUsing(fn() => $record->specialty_en),
                    TextEntry::make('specialty_ar')
                        ->label('Specialty (AR)')
                        ->getStateUsing(fn() => $record->specialty_ar),
                    TextEntry::make('description_en')
                        ->label('Description (EN)')
                        ->getStateUsing(fn() => $record->description_en),
                    TextEntry::make('description_ar')
                        ->label('Description (AR)')
                        ->getStateUsing(fn() => $record->description_ar),
                    TextEntry::make('experience')
                        ->label('Experience')
                        ->getStateUsing(fn() => $record->experience),
                ])
                ->columns(2),
            Section::make('Contacts')
                ->schema([
                    KeyValueEntry::make('contacts')
                        ->label('Contacts')
                        ->keyLabel('Platform')
                        ->valueLabel('URL')
                        ->getStateUsing(fn() => $record->contacts ?? []),
                ]),
                  Section::make('Media')
                    ->view('filament.settings.view-instructor-media', [
                        'record' => $this->record, // هنبعت الـ record للـ blade
                    ]),
        ]);
    }
}
