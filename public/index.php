<?php

use FastRoute\RouteCollector;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;


require __DIR__ . '/../vendor/autoload.php';
require_once './Controller/HomeController.php';
require_once './Controller/UserController.php';
require_once './Middleware/Autenticacao.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();



$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->group("/admin",function(RouteCollectorProxy $group){
$group->post('/',UserController::class . ":login");
});


$app->group("/api", function (RouteCollectorProxy $group){
$group->get('/',HomeController::class . ":index")->add(new Autenticacao());
$group->get('/{id}',HomeController::class . ":pesquisar")->add(new Autenticacao());
$group->post('/',HomeController::class . ":salvar")->add(new Autenticacao());
$group->put('/{id}',HomeController::class . ":editar")->add(new Autenticacao());
$group->delete('/{id}',HomeController::class . ":deletar")->add(new Autenticacao());
});

// Run app
$app->run();