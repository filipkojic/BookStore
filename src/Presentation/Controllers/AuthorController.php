<?php

require_once __DIR__ . '/../../Business/Services/AuthorService.php';
require_once __DIR__ . '/../../Data/Repositories/SessionAuthorRepository.php';
require_once __DIR__ . '/../../Infrastructure/HttpRequest.php';
require_once __DIR__ . '/../../Infrastructure/HttpResponse.php';

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
     *
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function index(HttpRequest $request): HttpResponse {
        $authors = $this->authorService->getAllAuthors();
        foreach ($authors as $author) {
            $bookCount = $this->authorService->getBookCountByAuthorId($author->getId());
            $author->setBookCount($bookCount);
        }

        ob_start();
        include __DIR__ . '/../Views/authorList.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Create a new author.
     *
     * @param HttpRequest $request
     * @return HttpResponse
     */
    public function create(HttpRequest $request): HttpResponse {
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
                $response = new HttpResponse();
                $response->setStatusCode(302);
                $response->addHeader('Location', '/index.php');
                return $response;
            }
        }

        ob_start();
        include __DIR__ . '/../Views/addAuthor.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Edit an existing author.
     *
     * @param HttpRequest $request
     * @param int $id Author ID.
     * @return HttpResponse
     */
    public function edit(HttpRequest $request, int $id): HttpResponse {
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
                $response = new HttpResponse();
                $response->setStatusCode(302);
                $response->addHeader('Location', '/authorList.php');
                return $response;
            }
        }

        ob_start();
        include __DIR__ . '/../Views/editAuthor.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }

    /**
     * Delete an author.
     *
     * @param HttpRequest $request
     * @param int $id Author ID.
     * @return HttpResponse
     */
    public function delete(HttpRequest $request, int $id): HttpResponse {
        if ($request->getMethod() === "POST") {
            $this->authorService->deleteAuthor($id);
            $response = new HttpResponse();
            $response->setStatusCode(302);
            $response->addHeader('Location', '/index.php');
            return $response;
        }
        $author = $this->authorService->getAuthorById($id);

        ob_start();
        include __DIR__ . '/../Views/deleteAuthor.php';
        $content = ob_get_clean();

        $response = new HttpResponse();
        $response->setBody($content);
        return $response;
    }
}
