<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DisciplinskaOdg extends Notification{
    use Queueable;
    protected $_channel_with_email = ['database'];

    public $mail_data;

    public function __construct(array $mail_data = null){
        $this->mail_data =  (object)$mail_data;


        if(isset($this->mail_data->send_email) and $this->mail_data->send_email == true){
            array_push($this->_channel_with_email, 'mail'); // ako smo postavili send_email na true
            // dodajemo mail kao channel za slanje
        }
    }

    public function via($notifiable){
        return $this->_channel_with_email;
    }

    public function toMail($notifiable){
//        dd((new MailMessage)
//            ->subject(isset($this->mail_data->subject) ? $this->mail_data->subject : 'Obavijest sa portala')
//            ->from(isset($this->mail_data->from) ? $this->mail_data->from : 'Ovdje pišemo šta ta notifikacija radi ..')
//            ->line(isset($this->mail_data->message) ? $this->mail_data->message : 'Obavijest sa portala')
//
//            ->action('Kliknite ovdje za više detalja', url(isset($this->mail_data->link) ? $this->mail_data->link : '/')));

        return (new MailMessage)
            ->subject(isset($this->mail_data->subject) ? $this->mail_data->subject : 'Obavijest sa portala')
            ->from(isset($this->mail_data->from_address) ? $this->mail_data->from_address : 'noreply@email.com', isset($this->mail_data->from_address) ? $this->mail_data->from_address : 'Core-BD BOT')
            ->line(isset($this->mail_data->message) ? $this->mail_data->message : 'Sadržaj poruke')
            ->action('Kliknite ovdje za više detalja', url(isset($this->mail_data->link) ? $this->mail_data->link : '/'));
    }

    public function toArray($notifiable){
        return [
            'what'   => 'disciplinska',
            'property_id' => null,
            'poruka' => 'Službeniku '.$notifiable->ime.' '.$notifiable->prezime.' ističe disciplinska mjera za manje od 15 dana.',
        ];

    }
}
