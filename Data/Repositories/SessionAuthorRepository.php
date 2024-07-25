<?php

require_once __DIR__ . '/../Interfaces/AuthorRepositoryInterface.php';
require_once __DIR__ . '/../../Models/Author.php';
require_once __DIR__ . '/../../Utilities/SessionManager.php';

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
    private $session;

    /**
     * SessionAuthorRepository constructor.
     */
    public function __construct()
    {
        $this->session = SessionManager::getInstance();
        $authors = $this->session->get('authors');

        if (!$authors) {
            $authors = [
                (new Author(1, 'Pera', 'Peric', 2))->toArray(),
                (new Author(2, 'Mika', 'Mikic', 1))->toArray(),
                (new Author(3, 'Zika', 'Zikic', 1))->toArray(),
                (new Author(4, 'Nikola', 'Nikolic', 0))->toArray()
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
        $newAuthor = new Author($id, $firstName, $lastName, 0);
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
     * Increment the book count for an author.
     *
     * @param int $authorId Author ID.
     */
    public function incrementBookCount(int $authorId): void
    {
        foreach ($this->authors as $author) {
            if ($author->getId() === $authorId) {
                $author->setBookCount($author->getBookCount() + 1);
                $this->updateSession();
                return;
            }
        }
    }

    /**
     * Decrement the book count for an author.
     *
     * @param int $authorId Author ID.
     */
    public function decrementBookCount(int $authorId): void
    {
        foreach ($this->authors as $author) {
            if ($author->getId() === $authorId) {
                $author->setBookCount($author->getBookCount() - 1);
                $this->updateSession();
                return;
            }
        }
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
