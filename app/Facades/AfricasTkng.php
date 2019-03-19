<?php

namespace App\Facades;



use Illuminate\Support\Facades\Facade;

class AfricasTkng extends Facade {
    protected static function getFacadeAccessor () {
        return 'africa_talk';
    }
}