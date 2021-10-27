<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;



require __DIR__ . '/../vendor/autoload.php';
require_once './Controller/HomeController.php';




$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/',HomeController::class . ":index");
$app->get('/{id}',HomeController::class . ":pesquisar");
$app->post('/',HomeController::class . ":salvar");
$app->put('/{id}',HomeController::class . ":editar");
$app->delete('/{id}',HomeController::class . ":deletar");

// Run app
$app->run();