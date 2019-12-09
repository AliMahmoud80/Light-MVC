<?php


namespace Light\Controllers;


class ContrllerHandler
{
    public function __construct($controller, $data)
    {
        $controller = explode('@' , $controller);

        $controllerName = $controller[0];
        $controllerAction = $controller[1];

        $controllerName = "\\App\\Controllers\\" . $controllerName;

        $controllerObj = new $controllerName;
        $controllerObj->$controllerAction($data);

    }
}