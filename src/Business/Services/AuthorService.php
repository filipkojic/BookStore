<?php

namespace Filip\Bookstore\Business\Services;

use Filip\Bookstore\Business\DomainModels\DomainAuthor;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\BookRepositoryInterface;
use Filip\Bookstore\Business\Interfaces\ServiceInterfaces\AuthorServiceInterface;

/**
 * Class AuthorService
 *
 * This class implements the AuthorServiceInterface interface.
 */
class AuthorService implements AuthorServiceInterface
{
    /**
     * AuthorService constructor.
     *
     * @param AuthorRepositoryInterface $authorRepository
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(
        private AuthorRepositoryInterface $authorRepository,
        private BookRepositoryInterface   $bookRepository
    )
    {
    }

    /**
     * Get all authors.
     *
     * @return DomainAuthor[] Array of DomainAuthor objects.
     */
    public function getAllAuthors(): array
    {
        return $this->authorRepository->getAll();
    }

    /**
     * Get author by ID.
     *
     * @param int $id DomainAuthor ID.
     * @return DomainAuthor|null DomainAuthor object or null if not found.
     */
    public function getAuthorById(int $id): ?DomainAuthor
    {
        return $this->authorRepository->getById($id);
    }

    /**
     * Add a new author.
     *
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor Newly created DomainAuthor object.
     */
    public function addAuthor(string $firstName, string $lastName): DomainAuthor
    {
        return $this->authorRepository->create($firstName, $lastName);
    }

    /**
     * Update an existing author.
     *
     * @param int $id DomainAuthor ID.
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor Updated DomainAuthor object.
     */
    public function updateAuthor(int $id, string $firstName, string $lastName): DomainAuthor
    {
        return $this->authorRepository->update($id, $firstName, $lastName);
    }

    /**
     * Delete an author and all their books.
     *
     * @param int $id DomainAuthor ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteAuthor(int $id): bool
    {
        $books = $this->bookRepository->getBooksByAuthorId($id);
        foreach ($books as $book) {
            $this->bookRepository->delete($book->getId());
        }

        return $this->authorRepository->delete($id);
    }

    /**
     * Get the book count for a given author.
     *
     * @param int $authorId DomainAuthor ID.
     * @return int Number of books by the given author.
     */
    public function getBookCountByAuthorId(int $authorId): int
    {
        return $this->bookRepository->getBookCountByAuthorId($authorId);
    }

}
