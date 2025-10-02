<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Courses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(2)->schema([
                        // Course Image
                        Forms\Components\FileUpload::make('image')
                            ->label('Course Image')
                            ->image()
                            ->directory('courses')
                            ->disk('public')
                            ->helperText('Upload course cover image'),

                        // Instructor
                        Forms\Components\TextInput::make('instructor')
                            ->label('Instructor')
                            ->default('Barakat Aziz')
                            ->required(),
                    ]),

                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->label('Title (EN)')
                            ->required(),

                        Forms\Components\TextInput::make('title_ar')
                            ->label('Title (AR)')
                            ->required(),
                    ]),

                    Forms\Components\Textarea::make('description_en')
                        ->label('Description (EN)')
                        ->rows(4),

                    Forms\Components\Textarea::make('description_ar')
                        ->label('Description (AR)')
                        ->rows(4),

                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('price_usd')
                            ->numeric()
                            ->label('Price (USD)')
                            ->required(),

                        Forms\Components\TextInput::make('price_egp')
                            ->numeric()
                            ->label('Price (EGP)')
                            ->required(),
                    ]),

                    Forms\Components\TextInput::make('duration_by_weak')
                        ->numeric()
                        ->label('Duration per Week (weeks )')
                        ->required(),

                    Forms\Components\Repeater::make('videos_ar')
                        ->label('Videos (AR)')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Video Title')
                                ->required(),
                            Forms\Components\TextInput::make('url')
                                ->label('Video URL')
                                ->url()
                                ->required(),
                        ])
                        ->default([])
                        ->collapsible()
                        ->orderable(),


                    Forms\Components\Repeater::make('videos_en')
                        ->label('Videos (EN)')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Video Title')
                                ->required(),
                            Forms\Components\TextInput::make('url')
                                ->label('Video URL')
                                ->url()
                                ->required(),
                        ])
                        ->default([])
                        ->collapsible()
                        ->orderable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . $record->image) : null)
                    ->label('Image')
                    ->size(100),

                TextColumn::make('title_en')->label('Title (EN)')->searchable()->sortable(),
                TextColumn::make('title_ar')->label('Title (AR)')->searchable()->sortable(),
                TextColumn::make('instructor')->label('Instructor')->sortable(),
                BadgeColumn::make('price_usd')->label('Price (USD)')->color('success'),
                BadgeColumn::make('price_egp')->label('Price (EGP)')->color('primary'),
                TextColumn::make('duration_by_weak')->label('Duration (Weeks)')->sortable(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make()->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make()->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->icon('heroicon-o-trash'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'view' => Pages\ViewCourse::route('/{record}'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
