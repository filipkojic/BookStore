<?php

namespace Filip\Bookstore\Infrastructure;

use Filip\Bookstore\Business\Interfaces\AuthorServiceInterface;
use Filip\Bookstore\Business\Interfaces\BookServiceInterface;
use Filip\Bookstore\Business\Services\AuthorService;
use Filip\Bookstore\Business\Services\BookService;
use Filip\Bookstore\Data\Repositories\SessionAuthorRepository;
use Filip\Bookstore\Data\Repositories\SessionBookRepository;
use Filip\Bookstore\Infrastructure\Utility\ServiceRegistry;
use Filip\Bookstore\Infrastructure\Utility\SessionManager;
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

        $sessionManager = SessionManager::getInstance();
        $authorRepository = new SessionAuthorRepository($sessionManager);
        $bookRepository = new SessionBookRepository($sessionManager);

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

