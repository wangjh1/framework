<?php
/**
 * Created by PhpStorm.
 * User: wangjinhao
 * Date: 2017/2/16
 * Time: 19:14
 */

require_once  __DIR__.'/../vendor/autoload.php';

ini_set('date.timezone','Asia/Shanghai');


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;

$request = Request::createFromGlobals();
$resquestStack = new RequestStack();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

$dispatcher = new EventDispatcher();
/*$errorHandler = function (Symfony\Component\Debug\Exception\FlattenException $exception) {
    $msg = 'Something went wrong! ('.$exception->getMessage().')';

    return new Response($msg, $exception->getStatusCode());
};*/
//$dispatcher->addSubscriber(new HttpKernel\EventListener\ExceptionListener($errorHandler));
$listener = new HttpKernel\EventListener\ExceptionListener(
    'Calendar\\Controller\\ErrorController::exceptionAction'
);
//$dispatcher->addSubscriber($listener);
//$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));
//$dispatcher->addSubscriber(new HttpKernel\EventListener\StreamedResponseListener());
//$dispatcher->addSubscriber(new Simplex\StringResponseListener());
$framework = new Simplex\Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);
/*$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__.'/../cache'),
    new HttpKernel\HttpCache\Esi(),
    array('debug' => true)
);*/

$framework->handle($request)->send();