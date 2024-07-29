<?php

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

