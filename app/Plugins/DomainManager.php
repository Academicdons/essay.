<?php
/**
 * Created by PhpStorm.
 * User: makindu
 * Date: 3/27/19
 * Time: 4:45 PM
 */

namespace App\Plugins;


use App\Models\FqdnConfiguration;

class DomainManager
{

    public static function one(){
        return 1;
    }

    public static function returnEmail()
    {
        return "admin@return.com";
    }

    public static function getTagLine()
    {
        return "Get a professional service";
    }

    public static function getDomain()
    {
        $domain = parse_url(request()->root())['host'];
        $dm = FqdnConfiguration::where('name',$domain)->first();
        if($dm == null){
            $dm = FqdnConfiguration::first();
        }
        return $dm;
    }

}