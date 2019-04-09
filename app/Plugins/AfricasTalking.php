<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 1/7/2018
 * Time: 11:22 PM
 */

namespace App\Plugins;


use Exception;
use Illuminate\Support\Facades\Log;

class AfricasTalking
{
    private $username="homeprowriters";
    private $api_key="76e674231fd5a932a21358bbaaaebc661b0343b0db17b15f9a8434403168c033";
    private $gateway=null;
    private $should_send_sms=true;

    public function __construct()
    {
//        if($trial_mode){
//            $this->gateway    = new AfricasTalkingGateway("sandbox", $this->sand_box_api_key,"sandbox");
//        }else{
            $this->gateway    = new AfricasTalkingGateway($this->username, $this->api_key);
//        }
    }

    public function getGateway()
    {
        return $this->gateway;
    }

    public function safeSend($recipients,$message)
    {
        $results=null;
        if($this->should_send_sms){
            try {
               $results  = $this->gateway->sendMessage($recipients, $message);
            }catch (Exception $e){
                $results=$e->getMessage();
            }

            return $results;
        }else{
            return null;
        }
    }
}