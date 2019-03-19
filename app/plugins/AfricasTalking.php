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
    private $username="find_it_web_app";
    private $api_key="5cf75ba4ce1f0b591241d3a972c14b79752ccf355a47bf54ff6560b86667031c";
//    private $sand_box_api_key="1755e87866a2f42b81b3db26017775988b4e86918dcd42ea1b64f88b3eb0f26b";
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