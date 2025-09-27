<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Payment Method Name'),
                Forms\Components\TextInput::make('account_name')
                    ->label('Account Holder Name'),
                Forms\Components\TextInput::make('account_number')
                    ->label('Account Number'),
                Forms\Components\TextInput::make('routing_number')
                    ->label('Routing Number'),
                Forms\Components\TextInput::make('iban')
                    ->label('IBAN'),
                Forms\Components\TextInput::make('swift')
                    ->label('SWIFT Code'),
                Forms\Components\TextInput::make('bank_name')
                    ->label('Bank Name'),
                Forms\Components\TextInput::make('bank_address')
                    ->label('Bank Address'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('account_name'),
                Tables\Columns\TextColumn::make('account_number'),
                Tables\Columns\TextColumn::make('bank_name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentMethods::route('/'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
