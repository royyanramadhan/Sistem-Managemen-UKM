<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification
{
    use Queueable;

    protected $keanggotaan;

    /**
     * Create a new notification instance.
     */
    public function __construct($keanggotaan)
    {
        $this->keanggotaan = $keanggotaan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Pendaftaran UKM baru dari ' . ($this->keanggotaan->user->name ?? '') . ' untuk ' . ($this->keanggotaan->ukm->nama ?? ''),
            'keanggotaan_id' => $this->keanggotaan->id,
            'user_id' => $this->keanggotaan->user_id,
            'ukm_id' => $this->keanggotaan->ukm_id,
        ];
    }
}
