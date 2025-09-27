<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use App\Models\Color;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Website Settings';
    protected static ?string $navigationGroup = 'settings';
    protected static ?string $pluralLabel = 'Settings';
    protected static ?string $modelLabel = 'Setting';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Website Information')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('logo_en')
                                ->label('Logo (English)')
                                ->required(),

                            TextInput::make('logo_ar')
                                ->label('Logo (Arabic)')
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('title_en')
                                ->label('Title (EN)')
                                ->required(),

                            TextInput::make('title_ar')
                                ->label('Title (AR)')
                                ->required(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('sub_title_en')
                                ->label('Sub Title (EN)')
                                ->required(),

                            TextInput::make('sub_title_ar')
                                ->label('Sub Title (AR)')
                                ->required(),
                        ]),
                    ]),

                Section::make('Banners')
                    ->schema([
                        Repeater::make('images')
                            ->label('Banners')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Upload Banner')
                                    ->image()
                                    ->directory('banners')
                                    ->visibility('public')
                                    ->storeFileNamesIn('image_name')
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->required(),
                            ])
                            ->minItems(1)
                            ->maxItems(10) 
                            ->reorderable()
                            ->columns(1),
                    ]),

                Section::make('Website Color')
                    ->schema([
                        Grid::make(1)->schema([
                            ColorPicker::make('color')
                                ->label('Website Color')
                                ->required(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('logo_en')->label('Logo EN')->sortable()->searchable(),
                TextColumn::make('logo_ar')->label('Logo AR')->sortable()->searchable(),
                TextColumn::make('title_en')->label('Title EN')->sortable()->searchable(),
                TextColumn::make('title_ar')->label('Title AR')->sortable()->searchable(),
                ColorColumn::make('color')->label('Website Color'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
            'view' => Pages\ViewSetting::route('/{record}'),
        ];
    }
}
