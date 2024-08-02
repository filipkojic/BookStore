<?php

use Filip\Bookstore\Infrastructure\Bootstrap;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\Utility\ServiceRegistry;
use Filip\Bookstore\Presentation\Controllers\AuthorController;
use Filip\Bookstore\Presentation\Controllers\BookController;

require_once __DIR__ . '/../vendor/autoload.php';

Bootstrap::initialize();

/** @var AuthorController $authorController */
$authorController = ServiceRegistry::getInstance()->get(AuthorController::class);
/** @var BookController $bookController */
$bookController = ServiceRegistry::getInstance()->get(BookController::class);

$request = new HttpRequest();
$response = null;

$page = $request->getPath();

switch ($page) {
    case 'authors':
        $response = $authorController->index($request);
        break;
    case 'addAuthor':
        $response = $authorController->create($request);
        break;
    case 'editAuthor':
        $response = $authorController->edit($request);
        break;
    case 'deleteAuthor':
        $response = $authorController->delete($request);
        break;
    case 'books':
        $response = $bookController->getBooksByAuthor($request);
        break;
    case 'editBook':
        $response = $bookController->edit($request);
        break;
    default:
        $response = $authorController->index($request);
        break;

    // ajax putanje
    case 'getBooks':
        $response = $bookController->getBooksForAuthor($request);
        break;

    case 'addBook':
        $response = $bookController->addBook($request);
        break;

    case 'deleteBook':
        $response = $bookController->deleteBook($request);
        break;
}

$response->send();
