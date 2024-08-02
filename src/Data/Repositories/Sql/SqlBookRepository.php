<?php

namespace Filip\Bookstore\Data\Repositories\Sql;

use Filip\Bookstore\Data\Interfaces\BookRepositoryInterface;
use Filip\Bookstore\Infrastructure\Utility\DatabaseConnection;
use Filip\Bookstore\Presentation\Models\Book;
use PDO;

/**
 * Class SQLBookRepository
 *
 * This class implements the BookRepositoryInterface interface using SQL database storage.
 */
class SqlBookRepository implements BookRepositoryInterface
{
    public function getAll(): array
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->query("SELECT * FROM Books");
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new Book($row['id'], $row['name'], $row['year'], $row['authorId']);
        }
        return $books;
    }

    public function getById(int $id): ?Book
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT * FROM Books WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Book($row['id'], $row['name'], $row['year'], $row['authorId']) : null;
    }

    public function create(string $name, int $year, int $authorId): Book
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("INSERT INTO Books (name, year, authorId) VALUES (:name, :year, :authorId)");
        $stmt->execute(['name' => $name, 'year' => $year, 'authorId' => $authorId]);
        $id = DatabaseConnection::getInstance()->getConnection()->lastInsertId();
        return new Book($id, $name, $year, $authorId);
    }

    public function update(int $id, string $name, int $year): ?Book
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("UPDATE Books SET name = :name, year = :year WHERE id = :id");
        $stmt->execute(['name' => $name, 'year' => $year, 'id' => $id]);
        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("DELETE FROM Books WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getBooksByAuthorId(int $authorId): array
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT * FROM Books WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = new Book($row['id'], $row['name'], $row['year'], $row['authorId']);
        }
        return $books;
    }

    public function getBookCountByAuthorId(int $authorId): int
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT COUNT(*) FROM Books WHERE authorId = :authorId");
        $stmt->execute(['authorId' => $authorId]);
        return (int)$stmt->fetchColumn();
    }
}
