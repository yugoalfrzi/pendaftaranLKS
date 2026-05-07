<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly string $reason = '') {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Akun Anda Ditolak - e-LKS Jawa Barat')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Mohon maaf, permohonan akun Anda di sistem e-LKS Jawa Barat **tidak dapat disetujui**.');

        if ($this->reason) {
            $mail->line('**Alasan:** ' . $this->reason);
        }

        return $mail
            ->line('Jika Anda merasa ini adalah kesalahan, silakan hubungi admin untuk informasi lebih lanjut.')
            ->salutation('Salam, Tim e-LKS Jawa Barat');
    }
}
