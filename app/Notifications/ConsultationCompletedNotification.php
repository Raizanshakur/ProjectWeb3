<?php

namespace App\Notifications;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConsultationCompletedNotification extends Notification
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
        return [
            'type'            => 'consultation_completed',
            'consultation_id' => $this->consultation->id,
            'title'           => 'Konsultasi Selesai',
            'message'         => 'Konsultasi Anda telah diselesaikan. Catatan dan anjuran dokter dapat dilihat pada detail konsultasi.',
            'action_url'      => route('consultations.show', $this->consultation->id),
            'category'        => 'consultation',
            'icon'            => 'clipboard-check',
        ];
    }
}
