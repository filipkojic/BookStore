<?php

namespace Filip\Bookstore\Infrastructure;

use Dotenv\Dotenv;
use Exception;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\BookRepositoryInterface;
use Filip\Bookstore\Business\Interfaces\ServiceInterfaces\AuthorServiceInterface;
use Filip\Bookstore\Business\Interfaces\ServiceInterfaces\BookServiceInterface;
use Filip\Bookstore\Business\Services\AuthorService;
use Filip\Bookstore\Business\Services\BookService;
use Filip\Bookstore\Data\Repositories\Sql\SqlAuthorRepository;
use Filip\Bookstore\Data\Repositories\Sql\SqlBookRepository;
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
     *
     * @throws Exception
     */
    public static function initialize(): void
    {
        // Load environment variables
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
        $dotenv->load();

        self::registerRepos();
        self::registerServices();
        self::registerControllers();
    }

    /**
     * Registers repository instances with the service registry.
     * @return void
     */
    protected static function registerRepos(): void
    {
        ServiceRegistry::getInstance()->register(AuthorRepositoryInterface::class, new SqlAuthorRepository());
        ServiceRegistry::getInstance()->register(BookRepositoryInterface::class, new SqlBookRepository());
    }

    /**
     * Registers service instances with the service registry.
     * @return void
     *
     * @throws Exception
     */
    protected static function registerServices(): void
    {
        ServiceRegistry::getInstance()->register(AuthorServiceInterface::class, new AuthorService(
            ServiceRegistry::getInstance()->get(AuthorRepositoryInterface::class),
            ServiceRegistry::getInstance()->get(BookRepositoryInterface::class)
        ));
        ServiceRegistry::getInstance()->register(BookServiceInterface::class, new BookService(
            ServiceRegistry::getInstance()->get(BookRepositoryInterface::class),
            ServiceRegistry::getInstance()->get(AuthorRepositoryInterface::class)
        ));
    }

    /**
     * Registers controller instances with the service registry.
     * @return void
     *
     * @throws Exception
     */
    protected static function registerControllers(): void
    {
        ServiceRegistry::getInstance()->register(AuthorController::class, new AuthorController(
            ServiceRegistry::getInstance()->get(AuthorServiceInterface::class)
        ));
        ServiceRegistry::getInstance()->register(BookController::class, new BookController(
            ServiceRegistry::getInstance()->get(BookServiceInterface::class)
        ));
    }
}
