<?php

namespace Filip\Bookstore\Data\Repositories\Session;

use Filip\Bookstore\Business\DomainModels\DomainBook;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\BookRepositoryInterface;
use Filip\Bookstore\Infrastructure\Utility\SessionManager;


/**
 * Class SessionBookRepository
 *
 * This class implements the BookRepositoryInterface interface using session storage.
 */
class SessionBookRepository implements BookRepositoryInterface
{
    /**
     * @var DomainBook[] Array of DomainBook objects.
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
                (new DomainBook(1, 'DomainBook Name', 2001, 1))->toArray(),
                (new DomainBook(2, 'DomainBook Name 2', 2002, 2))->toArray(),
                (new DomainBook(3, 'DomainBook Name 3', 1997, 3))->toArray(),
                (new DomainBook(4, 'DomainBook Name 4', 2005, 1))->toArray()
            ];
            $this->session->set('books', $books);
        }

        $this->books = DomainBook::fromBatch($books);
    }

    /**
     * Get all books.
     *
     * @return DomainBook[] Array of DomainBook objects.
     */
    public function getAll(): array
    {
        return $this->books;
    }

    /**
     * Get book by ID.
     *
     * @param int $id DomainBook ID.
     * @return DomainBook|null DomainBook object or null if not found.
     */
    public function getById(int $id): ?DomainBook
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
     * @param string $name DomainBook name.
     * @param int $year DomainBook year.
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook Newly created DomainBook object.
     */
    public function create(string $name, int $year, int $authorId): DomainBook
    {
        $lastBook = end($this->books);
        $id = $lastBook ? $lastBook->getId() + 1 : 1;
        $newBook = new DomainBook($id, $name, $year, $authorId);
        $this->books[] = $newBook;
        $this->updateSession();

        return $newBook;
    }

    /**
     * Update an existing book.
     *
     * @param int $id DomainBook ID.
     * @param string $name DomainBook name.
     * @param int $year DomainBook year.
     * @return DomainBook|null Updated DomainBook object or null if not found.
     */
    public function update(int $id, string $name, int $year): ?DomainBook
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
     * @param int $id DomainBook ID.
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
     * @param int $authorId DomainAuthor ID.
     * @return DomainBook[] Array of DomainBook objects by the given author.
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
     * @param int $authorId DomainAuthor ID.
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
        $this->session->set('books', array_map(function (DomainBook $book) {
            return $book->toArray();
        }, $this->books));
    }
}
