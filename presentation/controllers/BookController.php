<?php
require_once __DIR__ . '/../../business/services/BookService.php';
require_once __DIR__ . '/../../data/repositories/SessionBookRepository.php';

class BookController {
    private $bookService;

    public function __construct(IBookService $bookService) {
        $this->bookService = $bookService;
    }

    public function index() {
        $books = $this->bookService->getAllBooks();
        include __DIR__ . '/../views/booklist.php';
    }

    public function getBooksByAuthor($author_id) {
        $books = $this->bookService->getBooksByAuthorId($author_id);
        include __DIR__ . '/../views/booklist.php';
    }

    public function create() {
        $name_error = $year_error = "";
        $name = $year = "";
        $author_id = isset($_POST['author_id']) ? intval($_POST['author_id']) : null;

        // Proverite da li je forma poslata
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_submitted'])) {
            if (empty($_POST["name"])) {
                $name_error = "* This field is required";
            } elseif (strlen($_POST["name"]) > 250) {
                $name_error = "* Name must be less than 250 characters";
            } else {
                $name = htmlspecialchars($_POST["name"]);
            }

            if (empty($_POST["year"])) {
                $year_error = "* This field is required";
            } elseif (!is_numeric($_POST["year"]) || $_POST["year"] == 0 || $_POST["year"] < -5000 || $_POST["year"] > 999999) {
                $year_error = "* Year must be a number between -5000 and 999999 (0 is invalid)";
            } else {
                $year = intval($_POST["year"]);
            }

            if (empty($name_error) && empty($year_error)) {
                $this->bookService->addBook($name, $year, $author_id);
                header("Location: /books/" . $author_id);
                exit();
            }
        } else {
            // Ako forma nije poslata, postavite varijable za greške na prazne stringove
            $name_error = $year_error = "";
        }

        include __DIR__ . '/../views/addBook.php';
    }



    public function edit($id) {
        $book = $this->bookService->getBookById($id);
        $name_error = $year_error = "";
        $name = $book->getName();
        $year = $book->getYear();
        $authorId = $book->getAuthorId();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $name_error = "* This field is required";
            } elseif (strlen($_POST["name"]) > 250) {
                $name_error = "* Name must be less than 250 characters";
            } else {
                $name = htmlspecialchars($_POST["name"]);
            }

            if (empty($_POST["year"])) {
                $year_error = "* This field is required";
            } elseif (!is_numeric($_POST["year"]) || $_POST["year"] == 0 || $_POST["year"] < -5000 || $_POST["year"] > 999999) {
                $year_error = "* Year must be a number between -5000 and 999999 (0 is invalid)";
            } else {
                $year = intval($_POST["year"]);
            }

            if (empty($name_error) && empty($year_error)) {
                $this->bookService->updateBook($id, $name, $year);
                header("Location: /books/" . $authorId);
                exit();
            }
        }

        include __DIR__ . '/../views/editBook.php';
    }
    public function delete($id) {
        $book = $this->bookService->getBookById($id);
        $authorId = $book->getAuthorId();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->bookService->deleteBook($id);
            header("Location: /books/" . $authorId);
            exit();
        }

        include __DIR__ . '/../views/deleteBook.php';
    }
}

