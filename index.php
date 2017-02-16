<?php
/**
 * Created by PhpStorm.
 * User: wangjinhao
 * Date: 2017/2/16
 * Time: 13:13
 */

require_once __DIR__.'/init.php';

$input = $request->get('name', 'World');

$response->sendContent(sprintf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')));
$response->send();