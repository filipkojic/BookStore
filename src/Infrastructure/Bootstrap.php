<?php

namespace Filip\Bookstore\Infrastructure;

use Filip\Bookstore\Business\Interfaces\AuthorServiceInterface;
use Filip\Bookstore\Business\Interfaces\BookServiceInterface;
use Filip\Bookstore\Business\Services\AuthorService;
use Filip\Bookstore\Business\Services\BookService;
use Filip\Bookstore\Data\Repositories\Sql\SqlAuthorRepository;
use Filip\Bookstore\Data\Repositories\Sql\SqlBookRepository;
use Filip\Bookstore\Infrastructure\Utility\DatabaseConnection;
use Filip\Bookstore\Infrastructure\Utility\ServiceRegistry;
use Filip\Bookstore\Presentation\Controllers\AuthorController;
use Filip\Bookstore\Presentation\Controllers\BookController;

/**
 * Class Bootstrap
 *
 * This class initializes and registers all the necessary services and controllers.
 */
class Bootstrap
{
    /**
     * Initialize and register all services and controllers.
     */
    public static function initialize(): void
    {
        $registry = ServiceRegistry::getInstance();

        $authorRepository = new SQLAuthorRepository();
        $bookRepository = new SQLBookRepository();

        $authorService = new AuthorService($authorRepository, $bookRepository);
        $bookService = new BookService($bookRepository, $authorRepository);

        $authorController = new AuthorController($authorService);
        $bookController = new BookController($bookService);

        $registry->register(AuthorServiceInterface::class, $authorService);
        $registry->register(BookServiceInterface::class, $bookService);
        $registry->register(AuthorController::class, $authorController);
        $registry->register(BookController::class, $bookController);
    }
}
