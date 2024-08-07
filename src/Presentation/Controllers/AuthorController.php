<?php

namespace Filip\Bookstore\Presentation\Controllers;

use Filip\Bookstore\Business\Services\AuthorService;
use Filip\Bookstore\Infrastructure\HTTP\HttpRequest;
use Filip\Bookstore\Infrastructure\HTTP\Response\HtmlResponse;
use Filip\Bookstore\Presentation\Models\AuthorInput;
use Exception;

/**
 * Class AuthorController
 *
 * Handles author-related operations.
 */
class AuthorController
{
    /**
     * @var AuthorService
     */
    private AuthorService $authorService;

    /**
     * AuthorController constructor.
     *
     * @param AuthorService $authorService
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Displays a list of all authors.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function index(HttpRequest $request): HtmlResponse
    {
        $authors = $this->authorService->getAllAuthors();

        $headers = [
            "Cache-Control" => "no-cache, no-store, must-revalidate",
            "Pragma" => "no-cache",
            "Expires" => "0"
        ];

        return HtmlResponse::fromView(__DIR__ . '/../Views/authorList.php', ['authors' => $authors], 200, $headers);
    }

    /**
     * Creates a new author.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function create(HttpRequest $request): HtmlResponse
    {
        $firstNameError = $lastNameError = "";
        $firstName = $request->getBodyParam("firstName");
        $lastName = $request->getBodyParam("lastName");

        if ($request->getMethod() === "POST") {
            try {
                $authorInput = new AuthorInput($firstName, $lastName);
                $this->authorService->addAuthor($authorInput->getFirstName(), $authorInput->getLastName());
                return new HtmlResponse(302, ['Location' => '/index.php']);
            } catch (Exception $e) {
                $errors = json_decode($e->getMessage(), true);
                if (isset($errors['firstName'])) {
                    $firstName = '';
                    $firstNameError = $errors['firstName'];
                }
                if (isset($errors['lastName'])) {
                    $lastName = '';
                    $lastNameError = $errors['lastName'];
                }
            }
        }

        $firstName = htmlspecialchars($firstName ?? '', ENT_QUOTES, 'UTF-8');
        $lastName = htmlspecialchars($lastName ?? '', ENT_QUOTES, 'UTF-8');

        return HtmlResponse::fromView(__DIR__ . '/../Views/addAuthor.php', [
            'firstNameError' => $firstNameError,
            'lastNameError' => $lastNameError,
            'firstName' => $firstName,
            'lastName' => $lastName
        ]);
    }


    /**
     * Edits an existing author.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
    public function edit(HttpRequest $request): HtmlResponse
    {
        $id = $request->getId();
        $author = $this->authorService->getAuthorById($id);
        $firstNameError = $lastNameError = "";
        $firstName = $author->getFirstName();
        $lastName = $author->getLastName();

        if ($request->getMethod() === "POST") {
            $firstName = $request->getBodyParam("firstName");
            $lastName = $request->getBodyParam("lastName");

            try {
                $authorInput = new AuthorInput($firstName, $lastName);
                $this->authorService->updateAuthor($id, $authorInput->getFirstName(), $authorInput->getLastName());
                return new HtmlResponse(302, ['Location' => '/authorList.php']);
            } catch (Exception $e) {
                $errors = json_decode($e->getMessage(), true);
                if (isset($errors['firstName'])) {
                    $firstName = '';
                    $firstNameError = $errors['firstName'];
                }
                if (isset($errors['lastName'])) {
                    $lastName = '';
                    $lastNameError = $errors['lastName'];
                }
            }
        }

        return HtmlResponse::fromView(__DIR__ . '/../Views/editAuthor.php', [
            'author' => $author,
            'firstNameError' => $firstNameError,
            'lastNameError' => $lastNameError,
            'firstName' => htmlspecialchars($firstName),
            'lastName' => htmlspecialchars($lastName)
        ]);
    }


    /**
     * Deletes an author.
     *
     * @param HttpRequest $request
     * @return HtmlResponse
     */
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
