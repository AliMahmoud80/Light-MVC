<?php


namespace Light\Whoops;

class Whoops
{
    /**
     * Whoops constructor.
     */
    private function __construct() {}

    public static function Handle() :void
    {
        $whoops = new \Whoops\Run;
        $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }
}