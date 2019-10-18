<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class createPin extends Notification{
    use Queueable;
    protected $_channel_with_email = ['mail'];
    public $mail_data;
    public function __construct(array $mail_data = null){
        $this->mail_data =  (object) $mail_data;
    }

    public function via($notifiable){
        return $this->_channel_with_email;
    }

    public function toMail($notifiable){
        return (new MailMessage)
            ->subject(isset($this->mail_data->subject) ? $this->mail_data->subject : 'Obavijest sa portala')
            ->from(isset($this->mail_data->from_address) ? $this->mail_data->from_address : 'noreply@email.com', isset($this->mail_data->from_address) ? $this->mail_data->from_address : 'Core-FBiH BOT')
            ->line(isset($this->mail_data->message) ? $this->mail_data->message : 'Sadržaj poruke')
            ->line(isset($this->mail_data->username) ? 'Korisničko ime : '.$this->mail_data->username : 'ime.prezime')
            ->line(isset($this->mail_data->password) ? 'Šifra : '.$this->mail_data->password : '::vaša-šifra::')
            ->line(isset($this->mail_data->pin) ? 'PIN kod : '.$this->mail_data->pin : '0000')
            ->action(isset($this->mail_data->button) ? $this->mail_data->button : 'Kliknite ovdje za više detalja', url(isset($this->mail_data->link) ? $this->mail_data->link : '/'));
    }

    public function toArray($notifiable){
        return [
            'what'   => 'poruka',
            'property_id' => $notifiable->id,
            'poruka' => 'Službenik '.$notifiable->ime.' '.$notifiable->prezime.' -- poruka !!.',
        ];
    }
}
