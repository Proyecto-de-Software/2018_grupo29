<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'grupo29';
$config['db']['pass']   = 'ZWQwYzk5YzFhZTli';
$config['db']['dbname'] = 'grupo29';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/instituciones/{institucion-id}', function (Request $request, Response $response, array $args) {
    $idInstitucion = $args['institucion-id'];
    //$db = $this->db;
    $stmt = $this->db->prepare("SELECT * FROM institucion where id = ?");
    $stmt->execute([$idInstitucion]);
    $array = $stmt->fetchAll();
    $response->getBody()->write(json_encode($array));
    return $response;
});

$app->get('/instituciones/', function (Request $request, Response $response, array $args) {
    $stmt = $this->db->prepare("SELECT * FROM institucion");
    $stmt->execute();
    $array = $stmt->fetchAll();
    $response->getBody()->write(json_encode($array));
    return $response;
});

$app->run();