<?php

require_once __DIR__ . '/Infrastructure/Bootstrap.php';

Bootstrap::initialize();

$registry = ServiceRegistry::getInstance();

$authorController = $registry->get(AuthorController::class);
$bookController = $registry->get(BookController::class);

$url = isset($_GET['url']) ? $_GET['url'] : 'authors';
$urlParts = explode('/', $url);
$page = $urlParts[0];
$id = isset($urlParts[1]) ? $urlParts[1] : null;

switch ($page) {
    case 'authors':
        $authorController->index();
        break;
    case 'addAuthor':
        $authorController->create();
        break;
    case 'editAuthor':
        $authorController->edit($id);
        break;
    case 'deleteAuthor':
        $authorController->delete($id);
        break;
    case 'books':
        $bookController->getBooksByAuthor($id);
        break;
    case 'addBook':
        $bookController->create();
        break;
    case 'editBook':
        $bookController->edit($id);
        break;
    case 'deleteBook':
        $bookController->delete($id);
        break;
    default:
        $authorController->index();
        break;
}
