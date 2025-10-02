<?php

namespace App\Filament\Resources;

use App\Models\Enrollment;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use App\Filament\Resources\EnrollmentResource\Pages;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->label('Student'),
            Tables\Columns\TextColumn::make('email')->label('Email'),
            Tables\Columns\TextColumn::make('phone')->label('Phone'),
            Tables\Columns\TextColumn::make('course.title')->label('Course'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn (string $state) => ucfirst(str_replace('_', ' ', $state))),
        ])
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'pending_payment' => 'Pending Payment',
                    'waiting_verification' => 'Waiting Verification',
                    'confirmed' => 'Confirmed',
                    'rejected' => 'Rejected',
                ])
                ->label('Filter by Status'),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
}


    public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Student Info')
                    ->schema([
                        TextEntry::make('name')->label('Full Name'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('phone')->label('Phone'),
                    ])
                    ->columns(2),
                Infolists\Components\Section::make('Course Info')
                    ->schema([
                        TextEntry::make('course.title')->label('Course'),
                        TextEntry::make('course.price_usd')->label('Price (USD)'),
                        TextEntry::make('course.price_egp')->label('Price (EGP)'),
                        TextEntry::make('status')->label('Status')->badge(),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Payment Receipt')
                    ->schema([
                        ViewEntry::make('receipt_image')
                            ->view('filament.enrollments.receipt-view')
                            ->label('Receipt'),
                    ]),

                Infolists\Components\Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')->dateTime()->label('Created At'),
                        TextEntry::make('updated_at')->dateTime()->label('Updated At'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'view' => Pages\ViewEnrollment::route('/{record}'),
        ];
    }
}
