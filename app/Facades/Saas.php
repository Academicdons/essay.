<?php
/**
 * Created by PhpStorm.
 * User: makindu
 * Date: 3/27/19
 * Time: 4:45 PM
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class Saas extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "domain_manager";

    }
}