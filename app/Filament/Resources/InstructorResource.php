<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructorResource\Pages;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Instructors';

    // Form
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Section::make('Instructor Info')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('full_name_en')->label('Full Name (EN)')->required(),
                        TextInput::make('full_name_ar')->label('Full Name (AR)')->required(),
                        TextInput::make('specialty_en')->label('Specialty (EN)'),
                        TextInput::make('specialty_ar')->label('Specialty (AR)'),
                        TextInput::make('experience')->label('Experience'),
                    ]),
                    Grid::make(1)->schema([
                        Textarea::make('description_en')->label('Description (EN)'),
                        Textarea::make('description_ar')->label('Description (AR)'),
                    ]),
                ]),

          Section::make('Media')
    ->schema([
      Repeater::make('images')
    ->label('Images')
    ->schema([
        FileUpload::make('image')
            ->label('Upload Image')
            ->image() // لازم تكون صورة
            ->directory('instructors')
            ->visibility('public')
            ->storeFileNamesIn('images') // يخزن الاسم في العمود images
            ->imageResizeMode('cover') // لو عايزة resize
            ->imageCropAspectRatio('1:1') // لو عايزة crop
    ])
    ->columns(1)
    ]),

            Section::make('Contacts')
                ->schema([
                    KeyValue::make('contacts')
                        ->label('Contacts')
                        ->keyLabel('Platform')
                        ->valueLabel('URL')
                        ->valuePlaceholder('https://example.com'),
                ]),
        ]);
    }

    // Table
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([

            TextColumn::make('full_name_en')->label('Name (EN)')->sortable()->searchable(),
            TextColumn::make('specialty_en')->label('Specialty (EN)')->sortable(),
            TextColumn::make('experience')->label('Experience')->sortable(),

        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    // Pages
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructor::route('/create'),
            'edit' => Pages\EditInstructor::route('/{record}/edit'),
        ];
    }
}
