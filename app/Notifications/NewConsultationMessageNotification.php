<?php

namespace App\Notifications;

use App\Models\Consultation;
use App\Models\ConsultationMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewConsultationMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Consultation $consultation,
        public ConsultationMessage $consultationMessage
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isSenderUser = $this->consultationMessage->sender_type === 'user';
        
        $title = $isSenderUser
            ? 'Pesan Baru dari Orang Tua'
            : 'Pesan Baru dari Dokter';

        $actionUrl = $isSenderUser
            ? route('dokter.konsultasi.detail', $this->consultation->id)
            : route('consultations.show', $this->consultation->id);

        return [
            'type'            => 'new_message',
            'consultation_id' => $this->consultation->id,
            'title'           => $title,
            'message'         => Str::limit($this->consultationMessage->message, 100),
            'action_url'      => $actionUrl,
            'category'        => 'chat',
            'icon'            => 'message-square',
        ];
    }
}
