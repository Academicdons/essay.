<?php

namespace App\Notifications;

use App\Mail\RevisedOrderMail;
use App\Notifications\Channels\Africastkng;
use App\Notifications\Channels\OneSignalTag;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RevisedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {

        $this->message = $message;
    }
    public function via($notifiable)
    {
        return ['mail','database',OneSignalTag::class,Africastkng::class];
    }



    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return new RevisedOrderMail($notifiable,$this->message);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'text'=>$this->message
        ];
    }



    public function toDatabase($notifiable)
    {
        return [
            'text'=>$this->message
        ];
    }

    public function toOneSignalTag($notifiable)
    {

        $recipients=[];
        $recipients[]= ["field"=> "tag", "key"=> "user_id", "relation"=> "exists"];
        $recipients[]=["operator"=>"AND"];
        $recipients[]=["field" => "tag", "key" => "user_id", "relation" => "=", "value" => $notifiable->id];

        return [
            'tags'=>$recipients,
            'message'=>str_limit($this->message,50),
            'title'=>"New message",
            'data'=>["test"=>"foo"]
        ];
    }

    public function toAfricasTkng($notifiable)
    {
        return [
            'recipient'=>$notifiable->phone_number,
            'message'=>$this->message
        ];
    }
}
