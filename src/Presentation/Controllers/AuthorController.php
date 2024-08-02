<?php

namespace Filip\Bookstore\Presentation\Controllers;

use Filip\Bookstore\Business\Services\AuthorService;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\HTTP\Response\HtmlResponse;
use Filip\Bookstore\Presentation\Models\AuthorInput;
use Exception;

class AuthorController {

    private AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(HttpRequest $request): HtmlResponse
    {
        $authors = $this->authorService->getAllAuthors();
        foreach ($authors as $author) {
            $bookCount = $this->authorService->getBookCountByAuthorId($author->getId());
            $author->setBookCount($bookCount);
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/authorList.php', ['authors' => $authors]);
    }

    public function create(HttpRequest $request): HtmlResponse
    {
        $firstNameError = $lastNameError = "";
        $firstName = $lastName = "";

        if ($request->getMethod() === "POST") {
            try {
                $authorInput = new AuthorInput(
                    null,
                    $request->getBodyParam("firstName"),
                    $request->getBodyParam("lastName")
                );

                $this->authorService->addAuthor($authorInput->getFirstName(), $authorInput->getLastName());
                return new HtmlResponse(302, ['Location' => '/index.php']);
            } catch (Exception $e) {
                $errors = json_decode($e->getMessage(), true);
                if (isset($errors['firstName'])) {
                    $firstNameError = $errors['firstName'];
                }
                if (isset($errors['lastName'])) {
                    $lastNameError = $errors['lastName'];
                }
            }
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/addAuthor.php', [
            'firstNameError' => $firstNameError,
            'lastNameError' => $lastNameError,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }

    public function edit(HttpRequest $request): HtmlResponse
    {
        $id = $request->getId();
        $author = $this->authorService->getAuthorById($id);
        $firstNameError = $lastNameError = "";
        $firstName = $author->getFirstName();
        $lastName = $author->getLastName();

        if ($request->getMethod() === "POST") {
            try {
                $authorInput = new AuthorInput(
                    $id,
                    $request->getBodyParam("firstName"),
                    $request->getBodyParam("lastName"),
                    $author->getBookCount()
                );

                $this->authorService->updateAuthor($id, $authorInput->getFirstName(), $authorInput->getLastName());
                return new HtmlResponse(302, ['Location' => '/authorList.php']);
            } catch (Exception $e) {
                $errors = json_decode($e->getMessage(), true);
                if (isset($errors['firstName'])) {
                    $firstNameError = $errors['firstName'];
                }
                if (isset($errors['lastName'])) {
                    $lastNameError = $errors['lastName'];
                }
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

    public function delete(HttpRequest $request): HtmlResponse
    {
        $id = $request->getId();
        if ($request->getMethod() === "POST") {
            $this->authorService->deleteAuthor($id);
            return new HtmlResponse(302, ['Location' => '/index.php']);
        }
        $author = $this->authorService->getAuthorById($id);

        return HtmlResponse::fromView(__DIR__ . '/../Views/deleteAuthor.php', ['author' => $author]);
    }
}
