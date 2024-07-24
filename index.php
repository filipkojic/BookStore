<?php
require_once __DIR__ . '/utilities/SessionManager.php';
require_once __DIR__ . '/presentation/controllers/AuthorController.php';
require_once __DIR__ . '/presentation/controllers/BookController.php';
require_once __DIR__ . '/data/repositories/SessionAuthorRepository.php';
require_once __DIR__ . '/data/repositories/SessionBookRepository.php';
require_once __DIR__ . '/business/services/AuthorService.php';
require_once __DIR__ . '/business/services/BookService.php';

$session = SessionManager::getInstance();

//session_start();
//session_unset();
//session_destroy();
//session_start();

$sessionManager = SessionManager::getInstance();
$authorRepository = new SessionAuthorRepository($sessionManager);
$bookRepository = new SessionBookRepository($sessionManager);

$authorService = new AuthorService($authorRepository, $bookRepository);
$bookService = new BookService($bookRepository, $authorRepository);

$authorController = new AuthorController($authorService);
$bookController = new BookController($bookService);


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

