<?php

namespace Filip\Bookstore\Business\Services;

use Filip\Bookstore\Business\DomainModels\DomainBook;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\BookRepositoryInterface;
use Filip\Bookstore\Business\Interfaces\ServiceInterfaces\BookServiceInterface;


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
        private BookRepositoryInterface   $bookRepository,
        private AuthorRepositoryInterface $authorRepository
    )
    {
    }

    /**
     * Get all books.
     *
     * @return DomainBook[] Array of DomainBook objects.
     */
    public function getAllBooks(): array
    {
        return $this->bookRepository->getAll();
    }

    /**
     * Get book by ID.
     *
     * @param int $id DomainBook ID.
     * @return DomainBook|null DomainBook object or null if not found.
     */
    public function getBookById(int $id): ?DomainBook
    {
        return $this->bookRepository->getById($id);
    }

    /**
     * Add a new book.
     *
     * @param string $name DomainBook name.
     * @param int $year Publication year.
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook Newly created DomainBook object.
     */
    public function addBook(string $name, int $year, int $authorId): DomainBook
    {
        $newBook = $this->bookRepository->create($name, $year, $authorId);

        return $newBook;
    }

    /**
     * Update an existing book.
     *
     * @param int $id DomainBook ID.
     * @param string $name DomainBook name.
     * @param int $year Publication year.
     * @return DomainBook Updated DomainBook object.
     */
    public function updateBook(int $id, string $name, int $year): DomainBook
    {
        return $this->bookRepository->update($id, $name, $year);
    }

    /**
     * Delete a book.
     *
     * @param int $id DomainBook ID.
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
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook[] Array of DomainBook objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        return $this->bookRepository->getBooksByAuthorId($authorId);
    }
}
