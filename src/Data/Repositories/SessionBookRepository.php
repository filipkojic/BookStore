<?php

namespace Filip\Bookstore\Data\Repositories;

use Filip\Bookstore\Data\Interfaces\BookRepositoryInterface;
use Filip\Bookstore\Infrastructure\SessionManager;
use Filip\Bookstore\Models\Book;

/**
 * Class SessionBookRepository
 *
 * This class implements the BookRepositoryInterface interface using session storage.
 */
class SessionBookRepository implements BookRepositoryInterface
{
    /**
     * @var Book[] Array of Book objects.
     */
    private array $books;

    /**
     * @var SessionManager
     */
    private SessionManager $session;

    /**
     * SessionBookRepository constructor.
     */
    public function __construct()
    {
        $this->session = SessionManager::getInstance();
        $books = $this->session->get('books');

        if (!$books) {
            $books = [
                (new Book(1, 'Book Name', 2001, 1))->toArray(),
                (new Book(2, 'Book Name 2', 2002, 2))->toArray(),
                (new Book(3, 'Book Name 3', 1997, 3))->toArray(),
                (new Book(4, 'Book Name 4', 2005, 1))->toArray()
            ];
            $this->session->set('books', $books);
        }

        $this->books = Book::fromBatch($books);
    }

    /**
     * Get all books.
     *
     * @return Book[] Array of Book objects.
     */
    public function getAll(): array
    {
        return $this->books;
    }

    /**
     * Get book by ID.
     *
     * @param int $id Book ID.
     * @return Book|null Book object or null if not found.
     */
    public function getById(int $id): ?Book
    {
        foreach ($this->books as $book) {
            if ($book->getId() === $id) {
                return $book;
            }
        }

        return null;
    }

    /**
     * Create a new book.
     *
     * @param string $name Book name.
     * @param int $year Book year.
     * @param int $authorId Author ID.
     * @return Book Newly created Book object.
     */
    public function create(string $name, int $year, int $authorId): Book
    {
        $lastBook = end($this->books);
        $id = $lastBook ? $lastBook->getId() + 1 : 1;
        $newBook = new Book($id, $name, $year, $authorId);
        $this->books[] = $newBook;
        $this->updateSession();

        return $newBook;
    }

    /**
     * Update an existing book.
     *
     * @param int $id Book ID.
     * @param string $name Book name.
     * @param int $year Book year.
     * @return Book|null Updated Book object or null if not found.
     */
    public function update(int $id, string $name, int $year): ?Book
    {
        foreach ($this->books as $book) {
            if ($book->getId() === $id) {
                $book->setName($name);
                $book->setYear($year);
                $this->updateSession();
                return $book;
            }
        }

        return null;
    }

    /**
     * Delete a book.
     *
     * @param int $id Book ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(int $id): bool
    {
        foreach ($this->books as $key => $book) {
            if ($book->getId() === $id) {
                unset($this->books[$key]);
                $this->updateSession();
                return true;
            }
        }

        return false;
    }

    /**
     * Get books by author ID.
     *
     * @param int $authorId Author ID.
     * @return Book[] Array of Book objects by the given author.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        $authorBooks = [];
        foreach ($this->books as $book) {
            if ($book->getAuthorId() === $authorId) {
                $authorBooks[] = $book;
            }
        }

        return $authorBooks;
    }

    /**
     * Get the book count by author ID.
     *
     * @param int $authorId Author ID.
     * @return int Number of books by the given author.
     */
    public function getBookCountByAuthorId(int $authorId): int
    {
        $count = 0;
        foreach ($this->books as $book) {
            if ($book->getAuthorId() === $authorId) {
                $count++;
            }
        }

        return $count;
    }


    /**
     * Update the session storage with current books.
     */
    private function updateSession(): void
    {
        $this->session->set('books', array_map(function (Book $book) {
            return $book->toArray();
        }, $this->books));
    }
}
