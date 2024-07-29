<?php

namespace Filip\Bookstore\Data\Interfaces;

use Filip\Bookstore\Models\Book;

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
     * @return Book[] Array of Book objects.
     */
    public function getAll(): array;

    /**
     * Get book by ID.
     *
     * @param int $id Book ID.
     * @return Book|null Book object or null if not found.
     */
    public function getById(int $id): ?Book;

    /**
     * Create a new book.
     *
     * @param string $name Book name.
     * @param int $year Book year.
     * @param int $authorId Author ID.
     * @return Book Newly created Book object.
     */
    public function create(string $name, int $year, int $authorId): Book;

    /**
     * Update an existing book.
     *
     * @param int $id Book ID.
     * @param string $name Book name.
     * @param int $year Book year.
     * @return Book Updated Book object.
     */
    public function update(int $id, string $name, int $year): ?Book;

    /**
     * Delete a book.
     *
     * @param int $id Book ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Get books by author ID.
     *
     * @param int $authorId Author ID.
     * @return Book[] Array of Book objects by the given author.
     */
    public function getBooksByAuthorId(int $authorId): array;

    /**
     * Get the book count by author ID.
     *
     * @param int $authorId Author ID.
     * @return int Number of books by the given author.
     */
    public function getBookCountByAuthorId(int $authorId): int;
}
