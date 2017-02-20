<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/17
 * Time: 23:44
 */
namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;

class LeapYearController
{
    public function indexAction(Request $request, $year)
    {
        $leapyear = new LeapYear();
        if ($leapyear->isLeapyear($year)) {
            $response =  new Response('Yep, this is a leap year!');
        } else {
            $response = new Response('Nope, this is not a leap year.');
        }

        //$response->setTtl(10);

        return $response;
    }
}