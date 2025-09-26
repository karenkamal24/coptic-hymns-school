<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewSetting extends ViewRecord
{
    protected static string $resource = SettingResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Infolists\Components\Section::make('Logos')
                    ->schema([
                        Infolists\Components\TextEntry::make('logo_en')->label('logo EN'),
                        Infolists\Components\TextEntry::make('logo_ar')->label('logo AR'),
                    ])
                    ->columns(2),



                Infolists\Components\Section::make('Titles')
                    ->schema([
                        Infolists\Components\TextEntry::make('title_en')->label('Title EN'),
                        Infolists\Components\TextEntry::make('title_ar')->label('Title AR'),
                        Infolists\Components\TextEntry::make('sub_title_en')->label('Sub Title EN'),
                        Infolists\Components\TextEntry::make('sub_title_ar')->label('Sub Title AR'),
                    ])
                    ->columns(2),



                Infolists\Components\Section::make('Website Color')
                    ->schema([
                        Infolists\Components\ColorEntry::make('color')
                            ->label('Primary Color'),
                    ]),


                Infolists\Components\Section::make('Banners')
                    ->view('filament.settings.banners', [
                        'images' => $this->record->images ?? [],
                    ]),
            ]);
    }
}
