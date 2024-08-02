<?php

namespace Filip\Bookstore\Data\Repositories\Sql;

use Filip\Bookstore\Data\Interfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Presentation\Models\Author;
use PDO;

/**
 * Class SQLAuthorRepository
 *
 * This class implements the AuthorRepositoryInterface interface using SQL database storage.
 */
class SqlAuthorRepository implements AuthorRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        $stmt = $this->connection->query("SELECT a.id, a.firstName, a.lastName, COUNT(b.id) as bookCount
                                          FROM Authors a
                                          LEFT JOIN Books b ON a.id = b.authorId
                                          GROUP BY a.id, a.firstName, a.lastName");
        $authors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $authors[] = new Author($row['id'], $row['firstName'], $row['lastName'], $row['bookCount']);
        }
        return $authors;
    }

    public function getById(int $id): ?Author
    {
        $stmt = $this->connection->prepare("SELECT a.id, a.firstName, a.lastName, COUNT(b.id) as bookCount
                                            FROM Authors a
                                            LEFT JOIN Books b ON a.id = b.authorId
                                            WHERE a.id = :id
                                            GROUP BY a.id, a.firstName, a.lastName");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Author($row['id'], $row['firstName'], $row['lastName'], $row['bookCount']) : null;
    }

    public function create(string $firstName, string $lastName): Author
    {
        $stmt = $this->connection->prepare("INSERT INTO Authors (firstName, lastName) VALUES (:firstName, :lastName)");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName]);
        $id = $this->connection->lastInsertId();
        return new Author($id, $firstName, $lastName);
    }

    public function update(int $id, string $firstName, string $lastName): ?Author
    {
        $stmt = $this->connection->prepare("UPDATE Authors SET firstName = :firstName, lastName = :lastName WHERE id = :id");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'id' => $id]);
        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare("DELETE FROM Authors WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
