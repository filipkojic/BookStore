<?php

namespace Filip\Bookstore\Presentation\Controllers;

use Filip\Bookstore\Business\Services\AuthorService;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\HTTP\Response\HtmlResponse;

/**
 * Class AuthorController
 *
 * This class handles author-related operations.
 */
class AuthorController {

    /**
     * AuthorController constructor.
     *
     * @param AuthorService $authorService
     */
    public function __construct(
        private AuthorService $authorService
    ) {}

    /**
     * Display a list of all authors.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function index(HttpRequest $request): HtmlResponse {
        $authors = $this->authorService->getAllAuthors();
        foreach ($authors as $author) {
            $bookCount = $this->authorService->getBookCountByAuthorId($author->getId());
            $author->setBookCount($bookCount);
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/authorList.php', ['authors' => $authors]);
    }

    /**
     * Create a new author.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function create(HttpRequest $request): HtmlResponse {
        $firstNameError = $lastNameError = "";
        $firstName = $lastName = "";

        if ($request->getMethod() === "POST") {
            $firstName = $request->getBodyParam("firstName");
            $lastName = $request->getBodyParam("lastName");

            if (empty($firstName)) {
                $firstNameError = "* This field is required";
            } elseif (strlen($firstName) > 100) {
                $firstNameError = "* First name must be less than 100 characters";
            } else {
                $firstName = htmlspecialchars($firstName);
            }

            if (empty($lastName)) {
                $lastNameError = "* This field is required";
            } elseif (strlen($lastName) > 100) {
                $lastNameError = "* Last name must be less than 100 characters";
            } else {
                $lastName = htmlspecialchars($lastName);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->addAuthor($firstName, $lastName);
                return new HtmlResponse(302, ['Location' => '/index.php']);
            }
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/addAuthor.php', [
            'firstNameError' => $firstNameError,
            'lastNameError' => $lastNameError,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }

    /**
     * Edit an existing author.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function edit(HttpRequest $request): HtmlResponse {
        $id = $request->getId();
        $author = $this->authorService->getAuthorById($id);
        $firstNameError = $lastNameError = "";
        $firstName = $author->getFirstName();
        $lastName = $author->getLastName();

        if ($request->getMethod() === "POST") {
            $firstName = $request->getBodyParam("firstName");
            $lastName = $request->getBodyParam("lastName");

            if (empty($firstName)) {
                $firstNameError = "* This field is required";
            } elseif (strlen($firstName) > 100) {
                $firstNameError = "* First name must be less than 100 characters";
            } else {
                $firstName = htmlspecialchars($firstName);
            }

            if (empty($lastName)) {
                $lastNameError = "* This field is required";
            } elseif (strlen($lastName) > 100) {
                $lastNameError = "* Last name must be less than 100 characters";
            } else {
                $lastName = htmlspecialchars($lastName);
            }

            if (empty($firstNameError) && empty($lastNameError)) {
                $this->authorService->updateAuthor($id, $firstName, $lastName);
                return new HtmlResponse(302, ['Location' => '/authorList.php']);
            }
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/editAuthor.php', [
            'author' => $author,
            'firstNameError' => $firstNameError,
            'lastNameError' => $lastNameError,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }

    /**
     * Delete an author.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function delete(HttpRequest $request): HtmlResponse {
        $id = $request->getId();
        if ($request->getMethod() === "POST") {
            $this->authorService->deleteAuthor($id);
            return new HtmlResponse(302, ['Location' => '/index.php']);
        }
        $author = $this->authorService->getAuthorById($id);

        return HtmlResponse::fromView(__DIR__ . '/../Views/deleteAuthor.php', ['author' => $author]);
    }
}
