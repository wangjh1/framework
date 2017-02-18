<?php
/**
 * Created by PhpStorm.
 * User: wangjinhao
 * Date: 2017/2/17
 * Time: 12:51
 */
use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;

function is_leap_year($year = null)
{
    if (null === $year) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}


$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/leap_year/{year}', array(
    'year' => null,
    /*'_controller' => function ($request) {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }*/
    '_controller'=>'Calendar\\Controller\\LeapYearController::indexAction',
)));

return $routes;