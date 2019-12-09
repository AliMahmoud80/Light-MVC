<?php


namespace Light\App;

use Light\Config\ConfigHandler;

class App
{
    /**
     * App constructor.
     */
    private function __construct(){}

    public static function get($key): string
    {
        $app_settings = ConfigHandler::get('app');

        return $app_settings[$key];
    }
}