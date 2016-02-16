<?php
/**
 * User: Rayan Alamer
 * Date: 15/01/16
 * Time: 5:55 PM
 */


use Noodlehaus\Config as Config;

$injector = new \Auryn\Injector;

$injector->alias('Http\ResponseInterface', 'Bidaya\App\Response');
$injector->share('Bidaya\App\Response');



$injector->alias('Http\RequestInterface', 'Http\Request');
$injector->share('Http\Request');
$injector->define('Http\Request',[
    ':queries' => $_GET,
    ':requests' => $_POST,
    ':server' =>  $_SERVER,
    ':cookies' => $_COOKIE,
    ':files'   => $_FILES,
]);


$data = new Config(__DIR__.'/config.json');
$injector->share($data);


$config = new \Spot\Config();
$config->addConnection($data->get('database')['type'], [
    'dbname' => $data->get('database')['dname'],
    'user' => $data->get('database')['user'],
    'password' => $data->get('database')['password'],
    'host' => $data->get('database')['host'],
    'driver' => $data->get('database')['driver'],
    'charset' => $data->get('database')['charset'],
]);
$spot = new \Spot\Locator($config);

$injector->share($spot);

return $injector;