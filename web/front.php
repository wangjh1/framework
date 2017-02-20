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

/*function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}*/


/*$dispatcher->addListener('response', function(Simplex\ResponseEvent $event){
    $response = $event->getResponse();

    if ($response->isRedirection()
        || ($response->headers->has('Content-type') && false === strpos($response->headers->get('Content-Type'), 'html'))
        || 'html' !== $event->getRequest()->getRequestFormat()
    ) {
        return;
    }

    $response->setContent($response->getContent().'GA CODE');
});*/
/*$dispatcher = new EventDispatcher();
 * $dispatcher->addListener('response', function (Simplex\ResponseEvent $event) {
    $response = $event->getResponse();
    $headers = $response->headers;

    if (!$headers->has('Content-Length') && !$headers->has('Transfer-Encoding')) {
        $headers->set('Content-Length', strlen($response->getContent()));
    }
});*/


$request = Request::createFromGlobals();
$resquestStack = new RequestStack();
$routes = include __DIR__.'/../src/app.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new HttpKernel\Controller\ControllerResolver();
$argumentResolver = new HttpKernel\Controller\ArgumentResolver();

$dispatcher = new EventDispatcher();
$errorHandler = function (Symfony\Component\Debug\Exception\FlattenException $exception) {
    $msg = 'Something went wrong! ('.$exception->getMessage().')';

    return new Response($msg, $exception->getStatusCode());
};
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $resquestStack));

$framework = new Simplex\Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);
/*$framework = new HttpKernel\HttpCache\HttpCache(
    $framework,
    new HttpKernel\HttpCache\Store(__DIR__.'/../cache'),
    new HttpKernel\HttpCache\Esi(),
    array('debug' => true)
);*/

$framework->handle($request)->send();