<?php

namespace App\Notifications;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConsultationRequestedNotification extends Notification
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
        $childName = $this->consultation->child?->name ?? 'anak';

        return [
            'type'            => 'consultation_requested',
            'consultation_id' => $this->consultation->id,
            'title'           => 'Permintaan Konsultasi Baru',
            'message'         => "Permintaan konsultasi untuk {$childName} sedang menunggu persetujuan Anda.",
            'action_url'      => route('dokter.konsultasi.detail', $this->consultation->id),
            'category'        => 'consultation',
            'icon'            => 'calendar',
        ];
    }
}
