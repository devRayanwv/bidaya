<?php
/**
 * User: rayan alamer
 * Date: 15/01/16
 * Time: 5:14 PM
 */
namespace Bidaya;
require __DIR__ . '/../vendor/autoload.php';

//date_default_timezone_set('America/Halifax');
error_reporting(E_ALL);
$environment = 'development';
ini_set('session.cookie_httponly', 1);

/**
 * Register the error handler
 */

$whoops = new \Whoops\Run;
if ($environment !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e){
        echo 'Friendly error page and send an email to the developer';
    });
}
$whoops->register();

$injector = include('Dependencies.php');

//
//$request = $injector->make('Http\HttpRequest');
//$response = $injector->make('Http\HttpResponse');

$req = $injector->make('Http\Request');
$res = $injector->make('Bidaya\App\Response');
$spot = $injector->make('Spot\Locator');
$data = $injector->make('Noodlehaus\Config');
$res->path = $data->get('paths')['view'];

$routeDefinitionCallback = function (\FastRoute\RouteCollector $r) {
    $routes = include('Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

$routeInfo = $dispatcher->dispatch($req->method(), $req->path());
switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $res->setContent('404 - Page not found');
        $res->setStatusCode(404);
        $res->send();
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $res->setContent('405 - Method not allowed');
        $res->setStatusCode(405);
        $res->send();
        break;
    case \FastRoute\Dispatcher::FOUND:
        $res->view_public = $data->get('paths')['view'];
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        $class = $injector->make($className);
        $class->$method($vars);
        break;
}
//echo $response->getContent();
