<?php

require_once __DIR__ . '/../Interfaces/BookServiceInterface.php';
require_once __DIR__ . '/../../Data/Interfaces/BookRepositoryInterface.php';
require_once __DIR__ . '/../../Data/Interfaces/AuthorRepositoryInterface.php';

/**
 * Class BookService
 *
 * This class implements the BookServiceInterface interface.
 */
class BookService implements BookServiceInterface
{
    /**
     * @var BookRepositoryInterface
     */
    private BookRepositoryInterface $bookRepository;

    /**
     * @var AuthorRepositoryInterface
     */
    private AuthorRepositoryInterface $authorRepository;

    /**
     * BookService constructor.
     *
     * @param BookRepositoryInterface $bookRepository
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository, AuthorRepositoryInterface $authorRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
    }

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
