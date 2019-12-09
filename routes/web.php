<?php

use Light\Routes\Router;

Router::GET('/', 'HomeController@index');

Router::GET('/user/{id}', 'HomeController@user');