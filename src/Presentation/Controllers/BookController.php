<?php

/**
 * Class BookController
 *
 * This class handles book-related operations.
 */
class BookController {
    /**
     * @var BookService
     */
    private BookService $bookService;

    /**
     * BookController constructor.
     *
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Display a list of all books.
     *
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function index(HttpRequest $request): HttpResponse {
        $books = $this->bookService->getAllBooks();

        ob_start();
        include __DIR__ . '/../Views/bookList.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Display a list of books by author ID.
     *
     * @param HttpRequest $request
     * @param int $authorId Author ID.
     * @return HttpResponse
     */
    public function getBooksByAuthor(HttpRequest $request, int $authorId): HttpResponse {
        $books = $this->bookService->getBooksByAuthorId($authorId);

        ob_start();
        include __DIR__ . '/../Views/bookList.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Create a new book.
     *
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function create(HttpRequest $request): HttpResponse {
        $nameError = $yearError = "";
        $name = $year = "";
        $authorId = intval($request->getBodyParam('authorId', null));

        if ($request->getMethod() == "POST" && $request->getBodyParam('formSubmitted')) {
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
                $this->bookService->addBook($name, $year, $authorId);
                $response = new HttpResponse();
                $response->setStatusCode(302);
                $response->addHeader('Location', '/books/' . $authorId);
                return $response;
            }
        }

        ob_start();
        include __DIR__ . '/../Views/addBook.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Edit an existing book.
     *
     * @param HttpRequest $request
     * @param int $id Book ID.
     * @return HttpResponse
     */
    public function edit(HttpRequest $request, int $id): HttpResponse {
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
                $response = new HttpResponse();
                $response->setStatusCode(302);
                $response->addHeader('Location', '/books/' . $authorId);
                return $response;
            }
        }

        ob_start();
        include __DIR__ . '/../Views/editBook.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Delete a book.
     *
     * @param HttpRequest $request
     * @param int $id Book ID.
     * @return HttpResponse
     */
    public function delete(HttpRequest $request, int $id): HttpResponse {
        $book = $this->bookService->getBookById($id);
        $authorId = $book->getAuthorId();

        if ($request->getMethod() == "POST") {
            $this->bookService->deleteBook($id);
            $response = new HttpResponse();
            $response->setStatusCode(302);
            $response->addHeader('Location', '/books/' . $authorId);
            return $response;
        }

        ob_start();
        include __DIR__ . '/../Views/deleteBook.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }
}
