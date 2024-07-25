<?php

require_once __DIR__ . '/../Interfaces/AuthorServiceInterface.php';
require_once __DIR__ . '/../../Data/Interfaces/AuthorRepositoryInterface.php';
require_once __DIR__ . '/../../Data/Interfaces/BookRepositoryInterface.php';

/**
 * Class AuthorService
 *
 * This class implements the AuthorServiceInterface interface.
 */
class AuthorService implements AuthorServiceInterface
{
    /**
     * @var AuthorRepositoryInterface
     */
    private $authorRepository;

    /**
     * @var BookRepositoryInterface
     */
    private $bookRepository;

    /**
     * AuthorService constructor.
     *
     * @param AuthorRepositoryInterface $authorRepository
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(AuthorRepositoryInterface $authorRepository, BookRepositoryInterface $bookRepository)
    {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Get all authors.
     *
     * @return Author[] Array of Author objects.
     */
    public function getAllAuthors(): array
    {
        return $this->authorRepository->getAll();
    }

    /**
     * Get author by ID.
     *
     * @param int $id Author ID.
     * @return Author|null Author object or null if not found.
     */
    public function getAuthorById(int $id): ?Author
    {
        return $this->authorRepository->getById($id);
    }

    /**
     * Add a new author.
     *
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author Newly created Author object.
     */
    public function addAuthor(string $firstName, string $lastName): Author
    {
        return $this->authorRepository->create($firstName, $lastName);
    }

    /**
     * Update an existing author.
     *
     * @param int $id Author ID.
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author Updated Author object.
     */
    public function updateAuthor(int $id, string $firstName, string $lastName): Author
    {
        return $this->authorRepository->update($id, $firstName, $lastName);
    }

    /**
     * Delete an author and all their books.
     *
     * @param int $id Author ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function deleteAuthor(int $id): bool
    {
        $books = $this->bookRepository->getBooksByAuthorId($id);
        foreach ($books as $book) {
            $this->bookRepository->delete($book->getId());
        }
        return $this->authorRepository->delete($id);
    }
}
