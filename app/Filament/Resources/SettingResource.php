<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use App\Models\Color;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
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

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('logo_en')
                        ->label('Logo (English)')
                        ->required(),

                    Forms\Components\TextInput::make('logo_ar')
                        ->label('Logo (Arabic)')
                        ->required(),
                ]),


                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title_en')
                        ->label('Title (EN)')
                        ->required(),

                    Forms\Components\TextInput::make('title_ar')
                        ->label('Title (AR)')
                        ->required(),
                ]),

                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('sub_title_en')
                        ->label('Sub Title (EN)')
                        ->required(),

                    Forms\Components\TextInput::make('sub_title_ar')
                        ->label('Sub Title (AR)')
                        ->required(),
                ]),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\FileUpload::make('images')
                        ->label('Banners')
                        ->multiple()
                        ->reorderable()
                        ->minFiles(2)
                        ->maxFiles(10)
                        ->directory('banners')
                        ->image()
                        ->required(),
                ]),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\ColorPicker::make('color')
                        ->label('Website Color')
                        ->required(),
                ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('logo_en')->label('Logo EN')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('logo_ar')->label('Logo AR')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title_en')->label('Title EN')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('title_ar')->label('Title AR')->sortable()->searchable(),
                Tables\Columns\ColorColumn::make('color')->label('Website Color'),
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
