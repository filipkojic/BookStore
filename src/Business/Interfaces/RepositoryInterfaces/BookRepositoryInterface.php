<?php

namespace Filip\Bookstore\Business\Interfaces\RepositoryInterfaces;

use Filip\Bookstore\Business\DomainModels\DomainBook;

/**
 * Interface BookRepositoryInterface
 *
 * This interface defines the contract for book repository.
 */
interface BookRepositoryInterface
{
    /**
     * Get all books.
     *
     * @return DomainBook[] Array of DomainBook objects.
     */
    public function getAll(): array;

    /**
     * Get book by ID.
     *
     * @param int $id DomainBook ID.
     * @return DomainBook|null DomainBook object or null if not found.
     */
    public function getById(int $id): ?DomainBook;

    /**
     * Create a new book.
     *
     * @param string $name DomainBook name.
     * @param int $year DomainBook year.
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook Newly created DomainBook object.
     */
    public function create(string $name, int $year, int $authorId): DomainBook;

    /**
     * Update an existing book.
     *
     * @param int $id DomainBook ID.
     * @param string $name DomainBook name.
     * @param int $year DomainBook year.
     * @return DomainBook Updated DomainBook object.
     */
    public function update(int $id, string $name, int $year): ?DomainBook;

    /**
     * Delete a book.
     *
     * @param int $id DomainBook ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Get books by author ID.
     *
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook[] Array of DomainBook objects by the given author.
     */
    public function getBooksByAuthorId(int $authorId): array;

    /**
     * Get the book count by author ID.
     *
     * @param int $authorId DomainAuthor ID.
     * @return int Number of books by the given author.
     */
    public function getBookCountByAuthorId(int $authorId): int;
}
