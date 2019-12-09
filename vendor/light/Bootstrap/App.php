<?php

namespace Light\Bootstrap;

use Light\Http\RequestHandler;
use Light\Routes\Router;
use Light\Sessions\SessionHandler;
use Light\Config\ConfigHandler;
use Light\Storage\StorageHandler;
use Light\Whoops\Whoops;

/**
 * Class App
 * @package Light\Bootstrap
 *
 * Class App Responsible for Handling And Running The App
 */

class App {

    /**
     * App constructor.
     */
    private function __construct() {}

    /**
     * Handle All Main Services That Are Necessary To Run The App
     *
     * @return void
     */
    private function handle(): void
    {
        /**
         * Starting Sessions
         */
        SessionHandler::start();

        /**
         * Starting Whoops
         */
        Whoops::Handle();

        /**
         * Starting Router
         */
        Router::Handle();
    }

    /**
     * Run The App
     *
     * @return void
     */
    public static function run() :void
    {
        static::handle();
    }
}