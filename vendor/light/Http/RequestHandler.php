<?php


namespace Light\Http;

/**
 * Class RequestHandler
 * @package Light\Http
 *
 * Request Class Responsible for Getting The Informations From The Requests
 */

class RequestHandler
{
    /**
     * @var url
     * the full url
     */
    private static $url;

    /**
     * @var uri
     * The Full uri
     */
    private static $uri;

    /**
     * Request constructor.
     */
    private function __construct() {}

    /**
     * set the full URL
     * @return string $url
     */

    private function set_URL() :void
    {
        $protocol    = $_SERVER['REQUEST_SCHEME']; // http[s]://
        $server_name = $_SERVER['SERVER_NAME']; // example.com/
        $request_uri = $_SERVER['REQUEST_URI']; // /example/2

        $request_url = $protocol . '://' . $server_name . $request_uri;

        static::$url = $request_url;
    }

    /**
     * get the full URL
     * @return string
     */
    public static function URL() :string
    {
        static::set_URL();
        return static::$url;
    }

    /**
     * get the URI
     * @return string
     */
    public static function URI() :?string
    {
        static::$uri = $_SERVER['REQUEST_URI'];
        return static::$uri;
    }

}