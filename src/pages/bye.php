<?php
/**
 * Created by PhpStorm.
 * User: wangjinhao
 * Date: 2017/2/16
 * Time: 13:13
 */

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

$response = new Response('Goodbye');
$response->send();