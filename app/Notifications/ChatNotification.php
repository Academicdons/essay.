<?php

namespace App\Notifications;

use App\Notifications\Channels\OneSignalTag;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChatNotification extends Notification implements ShouldQueue
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
        //
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database',OneSignalTag::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)

                    ->line($notifiable->name . ' says: /n' . $this->message->message);
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
            //
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
            'message'=>str_limit($this->message->message,50),
            'title'=>"New message",
            'data'=>["test"=>"foo"]
        ];
    }
}
