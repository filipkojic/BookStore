<?php

namespace Filip\Bookstore\Data\Repositories\Session;

use Filip\Bookstore\Business\DomainModels\DomainAuthor;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Infrastructure\Utility\SessionManager;


/**
 * Class SessionAuthorRepository
 *
 * This class implements the AuthorRepositoryInterface interface using session storage.
 */
class SessionAuthorRepository implements AuthorRepositoryInterface
{
    /**
     * @var DomainAuthor[] Array of DomainAuthor objects.
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
                (new DomainAuthor(1, 'Pera', 'Peric'))->toArray(),
                (new DomainAuthor(2, 'Mika', 'Mikic'))->toArray(),
                (new DomainAuthor(3, 'Zika', 'Zikic'))->toArray(),
                (new DomainAuthor(4, 'Nikola', 'Nikolic'))->toArray()
            ];
            $this->session->set('authors', $authors);
        }

        $this->authors = DomainAuthor::fromBatch($authors);
    }

    /**
     * Get all authors.
     *
     * @return DomainAuthor[] Array of DomainAuthor objects.
     */
    public function getAll(): array
    {
        return $this->authors;
    }

    /**
     * Get author by ID.
     *
     * @param int $id DomainAuthor ID.
     * @return DomainAuthor|null DomainAuthor object or null if not found.
     */
    public function getById(int $id): ?DomainAuthor
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
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor Newly created DomainAuthor object.
     */
    public function create(string $firstName, string $lastName): DomainAuthor
    {
        $lastAuthor = end($this->authors);
        $id = $lastAuthor ? $lastAuthor->getId() + 1 : 1;
        $newAuthor = new DomainAuthor($id, $firstName, $lastName);
        $this->authors[] = $newAuthor;
        $this->updateSession();

        return $newAuthor;
    }

    /**
     * Update an existing author.
     *
     * @param int $id DomainAuthor ID.
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor|null Updated DomainAuthor object or null if not found.
     */
    public function update(int $id, string $firstName, string $lastName): ?DomainAuthor
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
     * @param int $id DomainAuthor ID.
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
        $this->session->set('authors', array_map(function (DomainAuthor $author) {
            return $author->toArray();
        }, $this->authors));
    }
}
