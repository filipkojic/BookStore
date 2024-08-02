<?php

namespace Filip\Bookstore\Presentation\Controllers;

use Exception;
use Filip\Bookstore\Business\Services\BookService;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\HTTP\Response\HtmlResponse;
use Filip\Bookstore\Infrastructure\HTTP\Response\JsonResponse;

/**
 * Class BookController
 *
 * This class handles book-related operations.
 */
class BookController {

    /**
     * BookController constructor.
     *
     * @param BookService $bookService
     */
    public function __construct(
        private BookService $bookService
    ) {}

    /**
     * Display a list of all books.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function index(HttpRequest $request): HtmlResponse {
        $books = $this->bookService->getAllBooks();

        return HtmlResponse::fromView(__DIR__ . '/../Views/bookList.php', ['books' => $books]);
    }

    /**
     * Display a list of books by author ID.
     *
     * @param HttpRequest $request
     * @param int $authorId Author ID.
     * @return HtmlResponse
     */
    public function getBooksByAuthor(HttpRequest $request, int $authorId): HtmlResponse {
        $books = $this->bookService->getBooksByAuthorId($authorId);

        return HtmlResponse::fromView(__DIR__ . '/../Views/bookList.php', ['books' => $books, 'authorId' => $authorId]);
    }

    /**
     * Edit an existing book.
     *
     * @param HttpRequest $request
     * @param int $id Book ID.
     * @return HtmlResponse
     */
    public function edit(HttpRequest $request, int $id): HtmlResponse {
        $book = $this->bookService->getBookById($id);
        $nameError = $yearError = "";
        $name = $book->getName();
        $year = $book->getYear();
        $authorId = $book->getAuthorId();

        if ($request->getMethod() == "POST") {
            $name = $request->getBodyParam("name");
            $year = $request->getBodyParam("year");

            if (empty($name)) {
                $nameError = "* This field is required";
            } elseif (strlen($name) > 250) {
                $nameError = "* Name must be less than 250 characters";
            } else {
                $name = htmlspecialchars($name);
            }

            if (empty($year)) {
                $yearError = "* This field is required";
            } elseif (!is_numeric($year) || $year == 0 || $year < -5000 || $year > 999999) {
                $yearError = "* Year must be a number between -5000 and 999999 (0 is invalid)";
            } else {
                $year = intval($year);
            }

            if (empty($nameError) && empty($yearError)) {
                $this->bookService->updateBook($id, $name, $year);
                return new HtmlResponse(302, ['Location' => '/books/' . $authorId]);
            }
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/editBook.php', [
            'nameError' => $nameError,
            'yearError' => $yearError,
            'name' => $name,
            'year' => $year,
            'authorId' => $authorId,
            'book' => $book
        ]);
    }

    // ajax metode
    /**
     * Get a list of books by author ID as a JSON response.
     *
     * @param HttpRequest $request
     * @param int $authorId
     * @return JsonResponse
     */
    public function getBooksForAuthor(HttpRequest $request, int $authorId): JsonResponse {
        $books = $this->bookService->getBooksByAuthorId($authorId);

        // Mapiranje podataka ako je potrebno
        $bookData = array_map(function($book) {
            return [
                'id' => $book->getId(),
                'title' => $book->getName(),
                'year' => $book->getYear()
            ];
        }, $books);

        return new JsonResponse(200, [], ['books' => $bookData]);
    }

    public function addBook(HttpRequest $request): JsonResponse {
        // Dobijanje JSON podataka iz tela zahteva
        $data = $request->getJsonBody();

        $title = $data['title'] ?? null;
        $year = $data['year'] ?? null;
        $authorId = $data['authorId'] ?? null;

        if ($title && $year && $authorId) {
            $book = $this->bookService->addBook($title, $year, (int)$authorId);

            $bookData = [
                'id' => $book->getId(),
                'title' => $book->getName(),
                'year' => $book->getYear(),
                'authorId' => $book->getAuthorId()
            ];

            return new JsonResponse(200, [], ['status' => 'success', 'book' => $bookData]);
        } else {
            return new JsonResponse(400, [], ['status' => 'error', 'message' => 'Invalid data']);
        }
    }

    public function deleteBook(HttpRequest $request, int $bookId): JsonResponse {
        try {
            $this->bookService->deleteBook($bookId);
            return new JsonResponse(200, [], ['status' => 'success']);
        } catch (Exception $e) {
            return new JsonResponse(500, [], ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
