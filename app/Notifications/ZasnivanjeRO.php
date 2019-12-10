<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ZasnivanjeRO extends Notification{
    use Queueable;
    protected $_channel_with_email = ['database'];
    public $mail_data;
    public function __construct(array $mail_data = null){
        $this->mail_data =  (object)$mail_data;


        if(isset($this->mail_data->send_email) and $this->mail_data->send_email == true){
            array_push($this->_channel_with_email, 'mail');
        }
    }

    public function via($notifiable){
        return $this->_channel_with_email;
    }

    public function toMail($notifiable){
        return (new MailMessage)
            ->subject(isset($this->mail_data->subject) ? $this->mail_data->subject : 'Obavijest sa portala')
            ->from(isset($this->mail_data->from_address) ? $this->mail_data->from_address : 'noreply@email.com', isset($this->mail_data->from_address) ? $this->mail_data->from_address : 'Core-BD BOT')
            ->line(isset($this->mail_data->message) ? $this->mail_data->message : 'Sadržaj poruke')
            ->action('Kliknite ovdje za više detalja', url(isset($this->mail_data->link) ? $this->mail_data->link : '/'));
    }

    public function toArray($notifiable){
        if($notifiable->getTable() == 'sluzbenici'){
            return [
                'what'   => 'zasnivanjeRO',
                'property_id' => $notifiable->zasnivanjeRORel[0]->id,
                'poruka' => 'Službenik '.$notifiable->ime.' '.$notifiable->prezime.' je zasnovao radni odnos prije 6 mjeseci.',
            ];
        }else return [];

    }
}
