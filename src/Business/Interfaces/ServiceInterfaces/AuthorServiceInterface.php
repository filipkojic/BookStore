<?php

namespace Filip\Bookstore\Business\Interfaces\ServiceInterfaces;

use Filip\Bookstore\Business\DomainModels\DomainAuthor;

/**
 * Interface AuthorServiceInterface
 *
 * This interface defines the contract for author service.
 */
interface AuthorServiceInterface
{
    /**
     * Get all authors.
     *
     * @return DomainAuthor[] Array of DomainAuthor objects.
     */
    public function getAllAuthors(): array;

    /**
     * Get author by ID.
     *
     * @param int $id DomainAuthor ID.
     * @return DomainAuthor|null DomainAuthor object or null if not found.
     */
    public function getAuthorById(int $id): ?DomainAuthor;

    /**
     * Add a new author.
     *
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor Newly created DomainAuthor object.
     */
    public function addAuthor(string $firstName, string $lastName): DomainAuthor;

    /**
     * Update an existing author.
     *
     * @param int $id DomainAuthor ID.
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor Updated DomainAuthor object.
     */
    public function updateAuthor(int $id, string $firstName, string $lastName): DomainAuthor;

    /**
     * Delete an author and all their books.
     *
     * @param int $id DomainAuthor ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteAuthor(int $id): bool;

    /**
     * Get the book count for a given author.
     *
     * @param int $authorId DomainAuthor ID.
     * @return int Number of books by the given author.
     */
    public function getBookCountByAuthorId(int $authorId): int;
}
