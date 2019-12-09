<?php


namespace Light\Lang;


use Light\Config\ConfigHandler;
use Light\Cookies\CookieHandler;

class LangHandler
{
    /**
     * LangHandler constructor.
     */
    private function __construct(){}

    private function Handle(): void
    {
        $lang_configs = ConfigHandler::get('Lang');

        $default_lang = $lang_configs['default_lang'];
        
        CookieHandler::create('lang', $default_lang);
    }

    public static function cahnge_lang($lang = 'en'): void
    {
        static::Handle();

        CookieHandler::delete('lang');
        CookieHandler::create('lang', $lang);
    }

    public static function get_lang_data($lang_name, $lang_file): array
    {
        static::Handle();

        $lang = require_once ROOT . DS . 'lang' . DS . $lang_name . DS . $lang_file . '.lang.php';

        return $lang;
    }
}