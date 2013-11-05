<?php namespace Tutik\Socialist;

/**
 * Class GooglePlus API
 * @package Tutik\Socialist
 */
class GooglePlus {

    protected
        $app_id,
        $app_key;

    public function __construct($config)
    {
        $this->app_id  = $config['app_id'];
        $this->app_key = $config['app_key'];
    }



    public function api($method , $arg)
    {


    }
    
}



