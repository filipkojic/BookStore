<?php
require_once __DIR__ . '/../../business/services/AuthorService.php';
require_once __DIR__ . '/../../data/repositories/SessionAuthorRepository.php';

class AuthorController {
    private $authorService;

    public function __construct(IAuthorService $authorService) {
        $this->authorService = $authorService;
    }

    public function index() {
        $authors = $this->authorService->getAllAuthors();
//        $new =[];
//        foreach ($authors as $author) {
//            $new[] = $author->toArray();
//        }
        include __DIR__ . '/../views/authorlist.php';
    }

    public function create() {
        $first_name_error = $last_name_error = "";
        $first_name = $last_name = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["first_name"])) {
                $first_name_error = "* This field is required";
            } elseif (strlen($_POST["first_name"]) > 100) {
                $first_name_error = "* First name must be less than 100 characters";
            } else {
                $first_name = htmlspecialchars($_POST["first_name"]);
            }

            if (empty($_POST["last_name"])) {
                $last_name_error = "* This field is required";
            } elseif (strlen($_POST["last_name"]) > 100) {
                $last_name_error = "* Last name must be less than 100 characters";
            } else {
                $last_name = htmlspecialchars($_POST["last_name"]);
            }

            if (empty($first_name_error) && empty($last_name_error)) {
                $this->authorService->addAuthor($first_name, $last_name);
                header("Location: /index.php");
                exit();
            }
        }

        include __DIR__ . '/../views/addAuthor.php';
    }

    public function edit($id) {
        $author = $this->authorService->getAuthorById($id);
        $first_name_error = $last_name_error = "";
        $first_name = $author->first_name;
        $last_name = $author->last_name;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["first_name"])) {
                $first_name_error = "* This field is required";
            } elseif (strlen($_POST["first_name"]) > 100) {
                $first_name_error = "* First name must be less than 100 characters";
            } else {
                $first_name = htmlspecialchars($_POST["first_name"]);
            }

            if (empty($_POST["last_name"])) {
                $last_name_error = "* This field is required";
            } elseif (strlen($_POST["last_name"]) > 100) {
                $last_name_error = "* Last name must be less than 100 characters";
            } else {
                $last_name = htmlspecialchars($_POST["last_name"]);
            }

            if (empty($first_name_error) && empty($last_name_error)) {
                $this->authorService->updateAuthor($id, $first_name, $last_name);
                header("Location: /authorlist.php");
                exit();
            }
        }

        include __DIR__ . '/../views/editAuthor.php';
    }

    public function delete($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->authorService->deleteAuthor($id);
            header("Location: /index.php");
            exit();
        }
        $author = $this->authorService->getAuthorById($id);
        include __DIR__ . '/../views/deleteAuthor.php';
    }
}
?>
