<?php

namespace App\Notifications;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConsultationCancelledNotification extends Notification
{
    use Queueable;

    public function __construct(public Consultation $consultation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $parentName = $this->consultation->user?->name ?? 'Orang Tua';

        return [
            'type'            => 'consultation_cancelled',
            'consultation_id' => $this->consultation->id,
            'title'           => 'Konsultasi Dibatalkan',
            'message'         => "Permintaan konsultasi oleh {$parentName} telah dibatalkan.",
            'action_url'      => route('dokter.konsultasi.detail', $this->consultation->id),
            'category'        => 'consultation',
            'icon'            => 'x-circle',
        ];
    }
}
