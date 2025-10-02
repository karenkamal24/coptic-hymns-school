<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use App\Filament\Resources\EnrollmentResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use App\Traits\SendMailTrait;

class ViewEnrollment extends ViewRecord
{
    use SendMailTrait; 

    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('accept')
                ->label('Accept')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->update(['status' => 'confirmed']);

                    $courseTitle = $record->course?->title ?? 'Your Course';
                    $msgTitle = "Enrollment Accepted";
                    $link = "https://coptichymnsschool.com";


                    $msgContent = "
            <h3>Congratulations </h3>
            <p>Dear {$record->name},</p>
            <p>Your enrollment has been <b>accepted</b> successfully.</p>
            <p>Course: <b>{$courseTitle}</b></p>
            <p>You can view all your approved courses here:
                <a href='{$link}' target='_blank'>Coptic Hymns School</a>
            </p>
            <p>We’re excited to see you soon!</p>
        ";

                    $this->sendEmail($record->email, $msgTitle, $msgContent);
                }),

            Actions\Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $enrollment = $this->record;

                    $enrollment->update([
                        'status' => 'rejected',
                    ]);

                    $courseTitle = $enrollment->course?->title ?? 'the course you applied for';
                    $msgTitle = "Enrollment Rejected";
                    $msgContent = "
                        <h3>Application Update </h3>
                        <p>Dear {$enrollment->name},</p>
                        <p>We regret to inform you that your enrollment for <b>{$courseTitle}</b> has been <b>rejected</b>.</p>
                        <p>If you believe this was a mistake or would like more information, please contact our support team.</p>
                        <p>Thank you for your interest.</p>
                    ";

                    $this->sendEmail($enrollment->email, $msgTitle, $msgContent);
                }),
        ];
    }
}
