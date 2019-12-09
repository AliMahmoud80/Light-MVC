<?php

/**
 * Router Class
 *
 * Deals With Routes And Back-End Response
 */

namespace Light\Routes;

use Light\Http\RequestHandler;
use Light\Config\ConfigHandler;
use Light\Controllers\ContrllerHandler;
use Light\Middlewares\MiddlewareHandler;


class Router
{
    private static $routes = [];
    private static $prefix = null;

    /**
     * Router constructor.
     */
    private function __construct(){}

    /**
     * Router Handler
     * It Scan The App/Config/Routing.config.json file the get configs for the routing
     * espicially the routing files in App/routes
     *
     * @return void
     */
    public static function Handle(): void
    {
        $routingConfigs = ConfigHandler::get('Routing');

        $routingFiles = explode(' ', $routingConfigs['RoutingFiles']);

        $routingFilesPath = ROOT . ConfigHandler::get('Structure')['Routes'] . DS;

        foreach ($routingFiles as $file) {
            require_once $routingFilesPath . $file . '.php';
        }

        static::Response();
    }

    /**
     * Route Create
     *
     * @param $uri
     * @param $method
     * @param $callback
     * @param $middlewares
     * @param $data
     *
     * @retrun void
     */
    private function create($uri, $method, $callback, $middlewares, $data): void
    {
        $prefix = static::$prefix;

        $route = [
            'uri' => $prefix . $uri,
            'method' => $method,
            'callback' => $callback,
            'prefix' => $prefix,
            'middlewares' => $middlewares,
            'url_data' => null
        ];

        if (preg_match("/{(\w+)}/", $route['uri'])) {
    
            $uri = RequestHandler::URI();
            
            $route_base = $route['uri'];

            $route['uri'] = preg_replace("/{(\w+)}/", "(\w+)", $route['uri']);
            $route['uri'] = '#^' . $route['uri'] . '$#';
            
            if (preg_match_all($route['uri'], $uri, $matches)){

                $route['url_data'] = $matches[1];

                $route['uri'] = $uri;
            }

        }

        static::$routes[] = $route;
    }

    /**
     * Prefix Routes
     * Deals With Routes With prefix to avoid code repeating
     *
     * @param $prefix
     * @param $callback
     */
    private function prefix($prefix, $callback): void
    {
        static::$prefix = $prefix;

        if(is_callable($callback))
            $callback();

        static::$prefix = '';
    }

    /**
     * Create Route With GET Method
     *
     * @param $uri
     * @param $callback
     * @param null $middlewares
     * @param null $data
     */
    public static function GET($uri, $callback, $middlewares = null, $data = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
            static::create($uri, 'GET', $callback, $middlewares, $data);

    }

    /**
     * Create Route With POST Method
     *
     * @param $uri
     * @param $callback
     * @param null $middlewares
     * @param null $data
     */
    public static function POST($uri, $callback, $middlewares = null, $data = null) :void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            static::create($uri, 'POST', $callback, $middlewares, $data);
    }

    /**
     * Get The Current Route
     *
     * @return array|null
     */
    public static function get_current_route(): ?array
    {
        $current_uri = RequestHandler::URI();

        $current_route = null;

        foreach (static::$routes as $route){
            if (RequestHandler::URI() == $route['uri']){
                $current_route = $route;
            }
        }

        if ($current_route === null)
            $current_route = static::$routes[0];


        return $current_route;
    }

    /**
     * Response Function
     * Deals With Responses
     *
     * @return void
     */
    public static function Response(): void
    {
        $current_route = static::get_current_route();

        if(is_callable($current_route['callback']))
            $current_route['callback']($current_route['url_data']);

        if (is_string($current_route['middlewares']))
            $middleware = new MiddlewareHandler($current_route['middlewares'], $current_route['url_data']);

        if (is_string($current_route['callback']))
            $controller = new ContrllerHandler($current_route['callback'], $current_route['url_data']);

    }

    /**
     * Check If The Route Exists
     *
     * @param $uri
     * @return bool
     */
    private static function Check_if_route_exists($uri): bool
    {
        foreach(static::$routes as $route){
            if($uri == $route['uri'])
                return true;
        }
        return false;
    }
}