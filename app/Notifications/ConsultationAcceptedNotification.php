<?php

namespace App\Notifications;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ConsultationAcceptedNotification extends Notification
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
        $doctorName = $this->consultation->doctor?->name ?? 'Dokter';

        return [
            'type'            => 'consultation_accepted',
            'consultation_id' => $this->consultation->id,
            'title'           => 'Konsultasi Diterima',
            'message'         => "{$doctorName} telah menerima permintaan konsultasi Anda. Sesi obrolan kini aktif.",
            'action_url'      => route('consultations.show', $this->consultation->id),
            'category'        => 'consultation',
            'icon'            => 'check-circle',
        ];
    }
}
