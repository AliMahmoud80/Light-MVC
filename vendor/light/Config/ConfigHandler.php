<?php


namespace Light\Config;

/**
 * Class ConfigHandler
 * @package Light\Config
 *
 * ConfigHandler Class Responsible for Reading The .Config.json files in ROOT/config
 */

class ConfigHandler
{
    /**
     * ConfigHandler constructor.
     */
    private function __construct() {}

    /**
     * Get The Config File Contents
     *
     * @param string $file_name
     * @return array | null
     */
    public function get($file_name)//: ?array
    {
        $content = null;

        $file_path = ROOT . DS . 'config' . DS . trim($file_name) . '.php';

        $content = require $file_path;

        return $content;
    }

}