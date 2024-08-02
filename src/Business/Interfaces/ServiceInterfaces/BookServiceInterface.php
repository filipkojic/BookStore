<?php

namespace Filip\Bookstore\Business\Interfaces\ServiceInterfaces;

use Filip\Bookstore\Business\DomainModels\DomainBook;

/**
 * Interface BookServiceInterface
 *
 * This interface defines the contract for book service.
 */
interface BookServiceInterface
{
    /**
     * Get all books.
     *
     * @return DomainBook[] Array of DomainBook objects.
     */
    public function getAllBooks(): array;

    /**
     * Get book by ID.
     *
     * @param int $id DomainBook ID.
     * @return DomainBook|null DomainBook object or null if not found.
     */
    public function getBookById(int $id): ?DomainBook;

    /**
     * Add a new book.
     *
     * @param string $name DomainBook name.
     * @param int $year Publication year.
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook Newly created DomainBook object.
     */
    public function addBook(string $name, int $year, int $authorId): DomainBook;

    /**
     * Update an existing book.
     *
     * @param int $id DomainBook ID.
     * @param string $name DomainBook name.
     * @param int $year Publication year.
     * @return DomainBook Updated DomainBook object.
     */
    public function updateBook(int $id, string $name, int $year): DomainBook;

    /**
     * Delete a book.
     *
     * @param int $id DomainBook ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteBook(int $id): bool;

    /**
     * Get books by author ID.
     *
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook[] Array of DomainBook objects.
     */
    public function getBooksByAuthorId(int $authorId): array;
}
