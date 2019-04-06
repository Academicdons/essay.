<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/8/2018
 * Time: 1:41 AM
 */

namespace App\Notifications\Channels;


use App\Plugins\OneSignalHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;


class OneSignalTag
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toOneSignalTag($notifiable);
        Log::info(OneSignalHelper::sendMessage($data['tags'],$data['title'],$data['message'],$data['data']));
    }

}