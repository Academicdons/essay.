<?php

namespace App\Plugins;


use App\Jobs\ThunderPushAsync;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Thunderpush{

    private $private_key='UJCWAglObn';
    private $server_url= "http://157.230.213.22:8080/api/1.0.0/MhPN3ItPqy/channels/";

    public function __construct()
    {

    }

    public function getChannelUrl($channel)
    {
        return $this->server_url  . $channel . "/";
    }

    public function notifyChannel($channel,$data)
    {
        $client = new Client(['headers' => [
            'X-Thunder-Secret-Key' => $this->private_key,
            'Content-Type'=>'application/json'
        ]]);
        $response = $client->post($this->getChannelUrl($channel), [
            RequestOptions::JSON=>$data
        ]);
        return $response;
    }


}

?>