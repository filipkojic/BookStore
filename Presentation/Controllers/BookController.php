<?php

require_once __DIR__ . '/../../Business/Services/BookService.php';
require_once __DIR__ . '/../../Data/Repositories/SessionBookRepository.php';

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
     */
    public function index(): void {
        $books = $this->bookService->getAllBooks();
        include __DIR__ . '/../Views/bookList.php';
    }

    /**
     * Display a list of books by author ID.
     *
     * @param int $authorId Author ID.
     */
    public function getBooksByAuthor(int $authorId): void {
        $books = $this->bookService->getBooksByAuthorId($authorId);
        include __DIR__ . '/../Views/bookList.php';
    }

    /**
     * Create a new book.
     */
    public function create(): void {
        $nameError = $yearError = "";
        $name = $year = "";
        $authorId = isset($_POST['authorId']) ? intval($_POST['authorId']) : null;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['formSubmitted'])) {
            if (empty($_POST["name"])) {
                $nameError = "* This field is required";
            } elseif (strlen($_POST["name"]) > 250) {
                $nameError = "* Name must be less than 250 characters";
            } else {
                $name = htmlspecialchars($_POST["name"]);
            }

            if (empty($_POST["year"])) {
                $yearError = "* This field is required";
            } elseif (!is_numeric($_POST["year"]) || $_POST["year"] == 0 || $_POST["year"] < -5000 || $_POST["year"] > 999999) {
                $yearError = "* Year must be a number between -5000 and 999999 (0 is invalid)";
            } else {
                $year = intval($_POST["year"]);
            }

            if (empty($nameError) && empty($yearError)) {
                $this->bookService->addBook($name, $year, $authorId);
                header("Location: /books/" . $authorId);
                exit();
            }
        } else {
            $nameError = $yearError = "";
        }

        include __DIR__ . '/../Views/addBook.php';
    }

    /**
     * Edit an existing book.
     *
     * @param int $id Book ID.
     */
    public function edit(int $id): void {
        $book = $this->bookService->getBookById($id);
        $nameError = $yearError = "";
        $name = $book->getName();
        $year = $book->getYear();
        $authorId = $book->getAuthorId();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $nameError = "* This field is required";
            } elseif (strlen($_POST["name"]) > 250) {
                $nameError = "* Name must be less than 250 characters";
            } else {
                $name = htmlspecialchars($_POST["name"]);
            }

            if (empty($_POST["year"])) {
                $yearError = "* This field is required";
            } elseif (!is_numeric($_POST["year"]) || $_POST["year"] == 0 || $_POST["year"] < -5000 || $_POST["year"] > 999999) {
                $yearError = "* Year must be a number between -5000 and 999999 (0 is invalid)";
            } else {
                $year = intval($_POST["year"]);
            }

            if (empty($nameError) && empty($yearError)) {
                $this->bookService->updateBook($id, $name, $year);
                header("Location: /books/" . $authorId);
                exit();
            }
        }

        include __DIR__ . '/../Views/editBook.php';
    }

    /**
     * Delete a book.
     *
     * @param int $id Book ID.
     */
    public function delete(int $id): void {
        $book = $this->bookService->getBookById($id);
        $authorId = $book->getAuthorId();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->bookService->deleteBook($id);
            header("Location: /books/" . $authorId);
            exit();
        }

        include __DIR__ . '/../Views/deleteBook.php';
    }
}
