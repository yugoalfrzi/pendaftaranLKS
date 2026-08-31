<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\LKS;

class LKSResubmitted extends Notification
{
    use Queueable;

    protected $lks;
    protected $user;
    protected $previousStatus;

    public function __construct(LKS $lks, $user, $previousStatus = null)
    {
        $this->lks = $lks;
        $this->user = $user;
        $this->previousStatus = $previousStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'lks_id' => $this->lks->id,
            'lks_name' => $this->lks->nama_lks,
            'user_id' => $this->user->id ?? null,
            'user_name' => $this->user->name ?? null,
            'previous_status' => $this->previousStatus,
            'admin_url' => route('admin.verification', $this->lks->id),
            'superadmin_url' => route('superadmin.verification', $this->lks->id),
            'message' => 'LKS telah dikirim kembali oleh pemilik untuk diverifikasi.',
        ];
    }
}
