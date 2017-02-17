<?php
/**
 * Created by PhpStorm.
 * User: wangjinhao
 * Date: 2017/2/17
 * Time: 12:51
 */
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Routing\Route('/hello/{name}', array('name' => 'World')));
$routes->add('bye', new Routing\Route('/bye'));

return $routes;