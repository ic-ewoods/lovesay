<?php

use Aura\Router\Generator;
use Aura\Router\Route;
use Aura\Router\RouteCollection;
use Aura\Router\RouteFactory;
use Aura\Router\Router;

/**
 * @return Route
 */
function getRoute()
{
    $routes = new RouteCollection(new RouteFactory());

    $routes->add('lovesay', '/')
        ->setValues(array(
            'controller' => 'lovesay'
        ));

    $routes->attachResource('note', '/note');

    $router = new Router($routes, new Generator());

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = $router->match($path, $_SERVER);

    return $route;  // note.read, etc
}