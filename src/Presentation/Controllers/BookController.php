<?php

namespace Filip\Bookstore\Presentation\Controllers;

use Filip\Bookstore\Business\Services\BookService;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\HTTP\Response\HtmlResponse;
use Filip\Bookstore\Infrastructure\HTTP\Response\JsonResponse;
use Filip\Bookstore\Presentation\Models\BookInput;
use Exception;

/**
 * Class BookController
 *
 * Handles book-related operations.
 */
class BookController
{
    /**
     * @var BookService
     */
    private BookService $bookService;

    /**
     * BookController constructor.
     *
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Displays a list of all books.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function index(HttpRequest $request): HtmlResponse
    {
        $books = $this->bookService->getAllBooks();

        return HtmlResponse::fromView(__DIR__ . '/../Views/bookList.php', ['books' => $books]);
    }

    /**
     * Displays a list of books by author ID.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function getBooksByAuthor(HttpRequest $request): HtmlResponse
    {
        $authorId = $request->getId();
        $books = $this->bookService->getBooksByAuthorId($authorId);

        return HtmlResponse::fromView(__DIR__ . '/../Views/bookList.php', ['books' => $books, 'authorId' => $authorId]);
    }

    /**
     * Edits an existing book.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function edit(HttpRequest $request): HtmlResponse
    {
        $id = $request->getId();
        $book = $this->bookService->getBookById($id);
        $nameError = $yearError = "";
        $name = $book->getName();
        $year = $book->getYear();
        $authorId = $book->getAuthorId();

        if ($request->getMethod() == "POST") {
            $name = $request->getBodyParam("name");
            $year = $request->getBodyParam("year");

            try {
                $bookInput = new BookInput($name, $year);
                $this->bookService->updateBook($id, $bookInput->getName(), $bookInput->getYear());
                return new HtmlResponse(302, ['Location' => '/books/' . $authorId]);
            } catch (Exception $e) {
                $errors = json_decode($e->getMessage(), true);
                if (isset($errors['name'])) {
                    $name = '';
                    $nameError = $errors['name'];
                }
                if (isset($errors['year'])) {
                    $year = '';
                    $yearError = $errors['year'];
                }
            }
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/editBook.php', [
            'nameError' => $nameError,
            'yearError' => $yearError,
            'name' => htmlspecialchars($name),
            'year' => htmlspecialchars($year),
            'authorId' => $authorId,
            'book' => $book
        ]);
    }


    /**
     * Returns a list of books by author ID as a JSON response.
     *
     * @param HttpRequest $request
     * @return JsonResponse
     */
    public function getBooksForAuthor(HttpRequest $request): JsonResponse
    {
        $authorId = $request->getId();
        $books = $this->bookService->getBooksByAuthorId($authorId);

        $bookData = array_map(function ($book) {
            return [
                'id' => $book->getId(),
                'title' => $book->getName(),
                'year' => $book->getYear()
            ];
        }, $books);

        return new JsonResponse(200, [], ['books' => $bookData]);
    }

    /**
     * Adds a new book.
     *
     * @param HttpRequest $request
     * @return JsonResponse
     */
    public function addBook(HttpRequest $request): JsonResponse
    {
        $data = $request->getJsonBody();

        try {
            $bookInput = new BookInput(
                $data['title'] ?? '',
                $data['year'] ?? 0
            );

            $book = $this->bookService->addBook($bookInput->getName(), $bookInput->getYear(), $data['authorId']);

            $bookData = [
                'id' => $book->getId(),
                'title' => $book->getName(),
                'year' => $book->getYear(),
                'authorId' => $book->getAuthorId()
            ];

            return new JsonResponse(200, [], ['status' => 'success', 'book' => $bookData]);
        } catch (Exception $e) {
            return new JsonResponse(400, [], ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Deletes a book.
     *
     * @param HttpRequest $request
     * @return JsonResponse
     */
    public function deleteBook(HttpRequest $request): JsonResponse
    {
        $bookId = $request->getId();
        try {
            $this->bookService->deleteBook($bookId);
            return new JsonResponse(200, [], ['status' => 'success']);
        } catch (Exception $e) {
            return new JsonResponse(500, [], ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
