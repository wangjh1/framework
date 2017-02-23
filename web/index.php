<?php
require_once  __DIR__.'/../vendor/autoload.php';

ini_set('date.timezone','Asia/Shanghai');
/*ini_set('display_errors','1');
error_reporting(E_ALL);*/

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;


$routes = new Routing\RouteCollection();

$routes->add('hello', new Routing\Route('/hello/{name}', array('_controller' =>
    function (Request $request) {
        return new Response(sprintf("Hello %s", $request->get('name')));
    }
)));

$resquestStack = new RequestStack();
$request = Request::createFromGlobals();

$context = new Routing\RequestContext();
$context->fromRequest($request);

$matcher = new  Routing\Matcher\UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $resquestStack));

$dispatcher->addSubscriber(new HttpKernel\EventListener\ExceptionListener(function (Request $request) {
         $msg = 'Something went wrong! ('.$request->get('exception')->getMessage().')';

     return new Response($msg, 500);
}));

$resolver = new HttpKernel\Controller\ControllerResolver();

$kernel = new HttpKernel\HttpKernel($dispatcher, $resolver);
$kernel = new HttpKernel\HttpCache\HttpCache(
    $kernel,
    new HttpKernel\HttpCache\Store(__DIR__.'/../cache'),
    new HttpKernel\HttpCache\Esi(),
    array('debug' => true));

$kernel->handle($request)->send();