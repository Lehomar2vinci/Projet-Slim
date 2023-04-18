<?php

require __DIR__ . '/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$items = [];

// Route to get all items
$app->get('/items', function (Request $request, Response $response, $args) use ($items) {
    $response->getBody()->write(json_encode($items));
    return $response->withHeader('Content-Type', 'application/json');
});

// Route to get a specific item
$app->get('/items/{id}', function (Request $request, Response $response, $args) use ($items) {
    $id = $args['id'];
    if (isset($items[$id])) {
        $response->getBody()->write(json_encode($items[$id]));
        return $response->withHeader('Content-Type', 'application/json');
    } else {
        return $response->withStatus(404);
    }
});

// Route to add an item
$app->post('/items', function (Request $request, Response $response, $args) use ($items) {
    $data = $request->getParsedBody();
    $items[] = $data;
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();