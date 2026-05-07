<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserApprovedNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Akun Anda Telah Disetujui - e-LKS Jawa Barat')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Selamat! Akun Anda di sistem e-LKS Jawa Barat telah **disetujui** oleh admin.')
            ->line('Anda sekarang dapat login dan menggunakan seluruh fitur sistem pendaftaran LKS.')
            ->line('Jika Anda memiliki pertanyaan, silakan hubungi admin.')
            ->salutation('Salam, Tim e-LKS Jawa Barat');
    }
}
