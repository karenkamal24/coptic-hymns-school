<?php

namespace App\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

trait SendMailTrait
{
    public function sendEmail($receiver_mail, $msg_title, $msg_content)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = config('mail.mailers.smtp.port', 465);

            //Recipients
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($receiver_mail);
            $mail->CharSet = 'UTF-8';

            //Content
            $mail->isHTML(true);
            $mail->Subject = $msg_title;
            $mail->Body = $msg_content;

            $mail->send();

            return [
                'status' => 200,
                'message' => 'Mail sent successfully',
            ];
        } catch (Exception $e) {
            \Log::error('Mail error: ' . $e->getMessage());

            return [
                'status' => 500,
                'error' => $e->getMessage(),
            ];
        }
    }
}
