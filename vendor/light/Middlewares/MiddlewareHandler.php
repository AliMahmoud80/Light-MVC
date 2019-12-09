<?php


namespace Light\Middlewares;


class MiddlewareHandler
{
    public function __construct($middlewares, $data)
    {
        $middlewares = explode('|' , $middlewares);

        foreach ($middlewares as $middleware) {
            $middleware = explode(':', $middleware);

            $middlewareName = $middleware[0];
            $middlewareAction = $middleware[1];

            $middlewareName = "\\App\\Middlewares\\" . $middlewareName;

            $middlewareObj = new $middlewareName;
            $middlewareObj->$middlewareAction($data);

        }
    }
}