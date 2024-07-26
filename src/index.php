<?php

require_once __DIR__ . '/Infrastructure/Bootstrap.php';
require_once __DIR__ . '/Infrastructure/HttpRequest.php';
require_once __DIR__ . '/Infrastructure/HttpResponse.php';

Bootstrap::initialize();

$registry = ServiceRegistry::getInstance();

$authorController = $registry->get(AuthorController::class);
$bookController = $registry->get(BookController::class);

$url = isset($_GET['url']) ? $_GET['url'] : 'authors';
$urlParts = explode('/', $url);
$page = $urlParts[0];
$id = isset($urlParts[1]) ? (int)$urlParts[1] : null;

$request = new HttpRequest();
$response = new HttpResponse();

switch ($page) {
    case 'authors':
        $response = $authorController->index($request);
        break;
    case 'addAuthor':
        $response = $authorController->create($request);
        break;
    case 'editAuthor':
        $response = $authorController->edit($request, $id);
        break;
    case 'deleteAuthor':
        $response = $authorController->delete($request, $id);
        break;
    case 'books':
        $response = $bookController->getBooksByAuthor($request, $id);
        break;
    case 'addBook':
        $response = $bookController->create($request);
        break;
    case 'editBook':
        $response = $bookController->edit($request, $id);
        break;
    case 'deleteBook':
        $response = $bookController->delete($request, $id);
        break;
    default:
        $response = $authorController->index($request);
        break;
}

// Send the response
$response->send();
