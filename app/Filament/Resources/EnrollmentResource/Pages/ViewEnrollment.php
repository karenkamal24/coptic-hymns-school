<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use App\Filament\Resources\EnrollmentResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewEnrollment extends ViewRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('accept')
                ->label('Accept')
                ->color('success')
                ->action(fn ($record) => $record->update(['status' => 'confirmed'])),

            Actions\Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->action(fn ($record) => $record->update(['status' => 'rejected'])),
        ];
    }
}
