<?php

require_once __DIR__ . '/../../Business/Services/AuthorService.php';
require_once __DIR__ . '/../../Data/Repositories/SessionAuthorRepository.php';

/**
 * Class AuthorController
 *
 * This class handles author-related operations.
 */
class AuthorController {
    /**
     * @var AuthorService
     */
    private AuthorService $authorService;

    /**
     * AuthorController constructor.
     *
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService) {
        $this->authorService = $authorService;
    }

    /**
     * Display a list of all authors.
     */
    public function index(): void {
        $authors = $this->authorService->getAllAuthors();
        foreach ($authors as $author) {
            $bookCount = $this->authorService->getBookCountByAuthorId($author->getId());
            $author->setBookCount($bookCount);
        }
        include __DIR__ . '/../Views/authorList.php';
    }


    /**
     * Create a new author.
     */
    public function create(): void {
        $firstNameError = $lastNameError = "";
        $firstName = $lastName = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["firstName"])) {
                $firstNameError = "* This field is required";
            } elseif (strlen($_POST["firstName"]) > 100) {
                $firstNameError = "* First name must be less than 100 characters";
            } else {
                $firstName = htmlspecialchars($_POST["firstName"]);
            }

            if (empty($_POST["lastName"])) {
                $lastNameError = "* This field is required";
            } elseif (strlen($_POST["lastName"]) > 100) {
                $lastNameError = "* Last name must be less than 100 characters";
            } else {
                $lastName = htmlspecialchars($_POST["lastName"]);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->addAuthor($firstName, $lastName);
                header("Location: /index.php");
                exit();
            }
        }

        include __DIR__ . '/../Views/addAuthor.php';
    }

    /**
     * Edit an existing author.
     *
     * @param int $id Author ID.
     */
    public function edit(int $id): void {
        $author = $this->authorService->getAuthorById($id);
        $firstNameError = $lastNameError = "";
        $firstName = $author->getFirstName();
        $lastName = $author->getLastName();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["firstName"])) {
                $firstNameError = "* This field is required";
            } elseif (strlen($_POST["firstName"]) > 100) {
                $firstNameError = "* First name must be less than 100 characters";
            } else {
                $firstName = htmlspecialchars($_POST["firstName"]);
            }

            if (empty($_POST["lastName"])) {
                $lastNameError = "* This field is required";
            } elseif (strlen($_POST["lastName"]) > 100) {
                $lastNameError = "* Last name must be less than 100 characters";
            } else {
                $lastName = htmlspecialchars($_POST["lastName"]);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->updateAuthor($id, $firstName, $lastName);
                header("Location: /authorList.php");
                exit();
            }
        }

        include __DIR__ . '/../Views/editAuthor.php';
    }

    /**
     * Delete an author.
     *
     * @param int $id Author ID.
     */
    public function delete(int $id): void {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->authorService->deleteAuthor($id);
            header("Location: /index.php");
            exit();
        }
        $author = $this->authorService->getAuthorById($id);
        include __DIR__ . '/../Views/deleteAuthor.php';
    }
}

