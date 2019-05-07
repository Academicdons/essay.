<?php

namespace App\Plugins;

class OneSignalHelper{

 public static function sendMessage($tags,$title,$message,$data){
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "e0f5df37-237c-4801-93b8-c1ac464031f9",
            'filters' => $tags,
            'data' => $data,
            'contents' => $content
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic NjllZmM4YTUtZDI0YS00N2RjLTliOTQtYzhmMDhjNTE2Yjgy'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);


        return $response;
    }

    public static function sendClientMessage($tags, $title, $message, $data)
    {

        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "9503cc91-2855-4e51-9ce8-f38a026069ec",
            'filters' => $tags,
            'data' => $data,
            'contents' => $content
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic NmVmZDc3MjYtNzZjNi00N2Q5LThiYjAtYzU4NTRhODI1MTBl'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);


        return $response;
    }
}
?>