<?php

namespace Filip\Bookstore\Data\Repositories\Sql;

use Filip\Bookstore\Business\DomainModels\DomainBook;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\BookRepositoryInterface;
use Filip\Bookstore\Infrastructure\Utility\DatabaseConnection;
use PDO;

/**
 * Class SqlBookRepository
 *
 * This class implements the BookRepositoryInterface interface using SQL database storage.
 */
class SqlBookRepository implements BookRepositoryInterface
{
    /**
     * Get all books.
     *
     * @return DomainBook[] An array of DomainBook objects.
     */
    public function getAll(): array
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->query("SELECT * FROM Books");
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new DomainBook($row['id'], $row['name'], $row['year'], $row['authorId']);
        }
        return $books;
    }

    /**
     * Get a book by its ID.
     *
     * @param int $id The ID of the book.
     * @return DomainBook|null The DomainBook object if found, null otherwise.
     */
    public function getById(int $id): ?DomainBook
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT * FROM Books WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new DomainBook($row['id'], $row['name'], $row['year'], $row['authorId']) : null;
    }

    /**
     * Create a new book.
     *
     * @param string $name The name of the book.
     * @param int $year The year of the book.
     * @param int $authorId The ID of the author of the book.
     * @return DomainBook The newly created DomainBook object.
     */
    public function create(string $name, int $year, int $authorId): DomainBook
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("INSERT INTO Books (name, year, authorId) VALUES (:name, :year, :authorId)");
        $stmt->execute(['name' => $name, 'year' => $year, 'authorId' => $authorId]);
        $id = DatabaseConnection::getInstance()->getConnection()->lastInsertId();
        return new DomainBook($id, $name, $year, $authorId);
    }

    /**
     * Update an existing book.
     *
     * @param int $id The ID of the book to update.
     * @param string $name The new name of the book.
     * @param int $year The new year of the book.
     * @return DomainBook|null The updated DomainBook object if found, null otherwise.
     */
    public function update(int $id, string $name, int $year): ?DomainBook
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("UPDATE Books SET name = :name, year = :year WHERE id = :id");
        $stmt->execute(['name' => $name, 'year' => $year, 'id' => $id]);
        return $this->getById($id);
    }

    /**
     * Delete a book by its ID.
     *
     * @param int $id The ID of the book to delete.
     * @return bool True on success, false on failure.
     */
    public function delete(int $id): bool
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("DELETE FROM Books WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Get all books by a specific author.
     *
     * @param int $authorId The ID of the author.
     * @return DomainBook[] An array of DomainBook objects.
     */
    public function getBooksByAuthorId(int $authorId): array
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT * FROM Books WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new DomainBook($row['id'], $row['name'], $row['year'], $row['authorId']);
        }
        return $books;
    }

    /**
     * Get the count of books by a specific author.
     *
     * @param int $authorId The ID of the author.
     * @return int The number of books by the author.
     */
    public function getBookCountByAuthorId(int $authorId): int
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT COUNT(*) FROM Books WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        return (int)$stmt->fetchColumn();
    }
}
