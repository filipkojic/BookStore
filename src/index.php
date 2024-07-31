<?php

use Filip\Bookstore\Infrastructure\Bootstrap;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\HTTP\AbstractResponse;
use Filip\Bookstore\Infrastructure\Utility\ServiceRegistry;
use Filip\Bookstore\Presentation\Controllers\AuthorController;
use Filip\Bookstore\Presentation\Controllers\BookController;

require_once __DIR__ . '/../vendor/autoload.php';

Bootstrap::initialize();

$registry = ServiceRegistry::getInstance();

/** @var AuthorController $authorController */
$authorController = $registry->get(AuthorController::class);
/** @var BookController $bookController */
$bookController = $registry->get(BookController::class);

$request = new HttpRequest();
$response = null;

$page = $request->getPath();
$id = $request->getId();

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
    case 'editBook':
        $response = $bookController->edit($request, $id);
        break;
    default:
        $response = $authorController->index($request);
        break;

    // ajax putanje
    case 'getBooks':
        $response = $bookController->getBooksForAuthor($request, $id);
        break;

    case 'addBook':
        $response = $bookController->addBook($request);
        break;

    case 'deleteBook':
        $response = $bookController->deleteBook($request, $id);
        break;
}

    $response->send();
