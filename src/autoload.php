<?php
require_once __DIR__ . '/Data/Interfaces/AuthorRepositoryInterface.php';
require_once __DIR__ . '/Data/Interfaces/BookRepositoryInterface.php';
require_once __DIR__ . '/Business/Interfaces/AuthorServiceInterface.php';
require_once __DIR__ . '/Business/Interfaces/BookServiceInterface.php';

require_once __DIR__ . '/Infrastructure/Singleton.php';
require_once __DIR__ . '/Infrastructure/GlobalWrapper.php';
require_once __DIR__ . '/Infrastructure/SessionManager.php';
require_once __DIR__ . '/Infrastructure/ServiceRegistry.php';
require_once __DIR__ . '/Infrastructure/HttpRequest.php';
require_once __DIR__ . '/Infrastructure/HttpResponse.php';
require_once __DIR__ . '/Infrastructure/Bootstrap.php';

require_once __DIR__ . '/Business/Services/AuthorService.php';
require_once __DIR__ . '/Business/Services/BookService.php';

require_once __DIR__ . '/Data/Repositories/SessionAuthorRepository.php';
require_once __DIR__ . '/Data/Repositories/SessionBookRepository.php';

require_once __DIR__ . '/Models/AbstractEntity.php';
require_once __DIR__ . '/Models/Author.php';
require_once __DIR__ . '/Models/Book.php';

require_once __DIR__ . '/Presentation/Controllers/AuthorController.php';
require_once __DIR__ . '/Presentation/Controllers/BookController.php';
