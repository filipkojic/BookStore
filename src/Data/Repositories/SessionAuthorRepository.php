<?php

namespace Filip\Bookstore\Data\Repositories;

use Filip\Bookstore\Data\Interfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Infrastructure\Utility\SessionManager;
use Filip\Bookstore\Presentation\Models\Author;


/**
 * Class SessionAuthorRepository
 *
 * This class implements the AuthorRepositoryInterface interface using session storage.
 */
class SessionAuthorRepository implements AuthorRepositoryInterface
{
    /**
     * @var Author[] Array of Author objects.
     */
    private $authors;

    /**
     * @var SessionManager
     */
    private SessionManager $session;

    /**
     * SessionAuthorRepository constructor.
     */
    public function __construct()
    {
        $this->session = SessionManager::getInstance();
        $authors = $this->session->get('authors');

        if (!$authors) {
            $authors = [
                (new Author(1, 'Pera', 'Peric'))->toArray(),
                (new Author(2, 'Mika', 'Mikic'))->toArray(),
                (new Author(3, 'Zika', 'Zikic'))->toArray(),
                (new Author(4, 'Nikola', 'Nikolic'))->toArray()
            ];
            $this->session->set('authors', $authors);
        }

        $this->authors = Author::fromBatch($authors);
    }

    /**
     * Get all authors.
     *
     * @return Author[] Array of Author objects.
     */
    public function getAll(): array
    {
        return $this->authors;
    }

    /**
     * Get author by ID.
     *
     * @param int $id Author ID.
     * @return Author|null Author object or null if not found.
     */
    public function getById(int $id): ?Author
    {
        foreach ($this->authors as $author) {
            if ($author->getId() === $id) {
                return $author;
            }
        }

        return null;
    }

    /**
     * Create a new author.
     *
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author Newly created Author object.
     */
    public function create(string $firstName, string $lastName): Author
    {
        $lastAuthor = end($this->authors);
        $id = $lastAuthor ? $lastAuthor->getId() + 1 : 1;
        $newAuthor = new Author($id, $firstName, $lastName);
        $this->authors[] = $newAuthor;
        $this->updateSession();

        return $newAuthor;
    }

    /**
     * Update an existing author.
     *
     * @param int $id Author ID.
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author|null Updated Author object or null if not found.
     */
    public function update(int $id, string $firstName, string $lastName): ?Author
    {
        foreach ($this->authors as $author) {
            if ($author->getId() === $id) {
                $author->setFirstName($firstName);
                $author->setLastName($lastName);
                $this->updateSession();
                return $author;
            }
        }

        return null;
    }

    /**
     * Delete an author.
     *
     * @param int $id Author ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        foreach ($this->authors as $key => $author) {
            if ($author->getId() === $id) {
                unset($this->authors[$key]);
                $this->updateSession();
                return true;
            }
        }

        return false;
    }

    /**
     * Update the session storage with current authors.
     */
    private function updateSession(): void
    {
        $this->session->set('authors', array_map(function (Author $author) {
            return $author->toArray();
        }, $this->authors));
    }
}
