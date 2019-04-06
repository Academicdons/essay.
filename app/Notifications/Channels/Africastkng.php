<?php


namespace App\Notifications\Channels;


use App\Plugins\AfricasTalking;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class Africastkng
{

    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toAfricasTkng($notifiable);
        Log::warning(json_encode($data));
        $at = new AfricasTalking();
        $at->safeSend($data['recipient'],$data['message']);
    }
}