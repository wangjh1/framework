<?php
/**
 * Created by PhpStorm.
 * User: wangjinhao
 * Date: 2017/2/20
 * Time: 13:03
 */
namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Debug\Exception\FlattenException;

class ErrorController
{
    public function exceptionAction(FlattenException $exception)
    {
        $msg = 'Something went wrong! ('.$exception->getMessage().')';

        return new Response($msg, $exception->getStatusCode());
    }
}