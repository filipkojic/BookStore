<?php

namespace Filip\Bookstore\Business\Interfaces;

use Filip\Bookstore\Presentation\Models\Book;

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
     * @return Book[] Array of Book objects.
     */
    public function getAllBooks(): array;

    /**
     * Get book by ID.
     *
     * @param int $id Book ID.
     * @return Book|null Book object or null if not found.
     */
    public function getBookById(int $id): ?Book;

    /**
     * Add a new book.
     *
     * @param string $name Book name.
     * @param int $year Publication year.
     * @param int $authorId Author ID.
     * @return Book Newly created Book object.
     */
    public function addBook(string $name, int $year, int $authorId): Book;

    /**
     * Update an existing book.
     *
     * @param int $id Book ID.
     * @param string $name Book name.
     * @param int $year Publication year.
     * @return Book Updated Book object.
     */
    public function updateBook(int $id, string $name, int $year): Book;

    /**
     * Delete a book.
     *
     * @param int $id Book ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteBook(int $id): bool;

    /**
     * Get books by author ID.
     *
     * @param int $authorId Author ID.
     * @return Book[] Array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array;
}
