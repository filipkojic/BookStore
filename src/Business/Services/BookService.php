<?php

namespace Filip\Bookstore\Business\Services;
use Filip\Bookstore\Business\Interfaces\BookServiceInterface;
use Filip\Bookstore\Data\Interfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Data\Interfaces\BookRepositoryInterface;
use Filip\Bookstore\Models\Book;

/**
 * Class BookService
 *
 * This class implements the BookServiceInterface interface.
 */
class BookService implements BookServiceInterface
{
    /**
     * BookService constructor.
     *
     * @param BookRepositoryInterface $bookRepository
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(
        private BookRepositoryInterface $bookRepository,
        private AuthorRepositoryInterface $authorRepository
    ) {}

    /**
     * Get all books.
     *
     * @return Book[] Array of Book objects.
     */
    public function getAllBooks(): array
    {
        return $this->bookRepository->getAll();
    }

    /**
     * Get book by ID.
     *
     * @param int $id Book ID.
     * @return Book|null Book object or null if not found.
     */
    public function getBookById(int $id): ?Book
    {
        return $this->bookRepository->getById($id);
    }

    /**
     * Add a new book.
     *
     * @param string $name Book name.
     * @param int $year Publication year.
     * @param int $authorId Author ID.
     * @return Book Newly created Book object.
     */
    public function addBook(string $name, int $year, int $authorId): Book
    {
        $newBook = $this->bookRepository->create($name, $year, $authorId);

        return $newBook;
    }

    /**
     * Update an existing book.
     *
     * @param int $id Book ID.
     * @param string $name Book name.
     * @param int $year Publication year.
     * @return Book Updated Book object.
     */
    public function updateBook(int $id, string $name, int $year): Book
    {
        return $this->bookRepository->update($id, $name, $year);
    }

    /**
     * Delete a book.
     *
     * @param int $id Book ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteBook(int $id): bool
    {
        $book = $this->bookRepository->getById($id);
        if ($book) {
            $this->bookRepository->delete($id);
            return true;
        }

        return false;
    }

    /**
     * Get books by author ID.
     *
     * @param int $authorId Author ID.
     * @return Book[] Array of Book objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        return $this->bookRepository->getBooksByAuthorId($authorId);
    }
}
