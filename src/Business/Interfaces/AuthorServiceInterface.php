<?php

namespace Filip\Bookstore\Business\Interfaces;
use Filip\Bookstore\Models\Author;

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
     * @return Author[] Array of Author objects.
     */
    public function getAllAuthors(): array;

    /**
     * Get author by ID.
     *
     * @param int $id Author ID.
     * @return Author|null Author object or null if not found.
     */
    public function getAuthorById(int $id): ?Author;

    /**
     * Add a new author.
     *
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author Newly created Author object.
     */
    public function addAuthor(string $firstName, string $lastName): Author;

    /**
     * Update an existing author.
     *
     * @param int $id Author ID.
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author Updated Author object.
     */
    public function updateAuthor(int $id, string $firstName, string $lastName): Author;

    /**
     * Delete an author and all their books.
     *
     * @param int $id Author ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteAuthor(int $id): bool;

    /**
     * Get the book count for a given author.
     *
     * @param int $authorId Author ID.
     * @return int Number of books by the given author.
     */
    public function getBookCountByAuthorId(int $authorId): int;
}
