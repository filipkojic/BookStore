<?php

namespace Filip\Bookstore\Data\Repositories\Sql;

use Filip\Bookstore\Business\DomainModels\DomainAuthor;
use Filip\Bookstore\Business\Interfaces\RepositoryInterfaces\AuthorRepositoryInterface;
use Filip\Bookstore\Infrastructure\Utility\DatabaseConnection;
use PDO;

/**
 * Class SQLAuthorRepository
 *
 * This class implements the AuthorRepositoryInterface interface using SQL database storage.
 */
class SqlAuthorRepository implements AuthorRepositoryInterface
{
    public function getAll(): array
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->query("SELECT a.id, a.firstName, a.lastName, COUNT(b.id) as bookCount
                                          FROM Authors a
                                          LEFT JOIN Books b ON a.id = b.authorId
                                          GROUP BY a.id, a.firstName, a.lastName");
        $authors = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $authors[] = new DomainAuthor($row['id'], $row['firstName'], $row['lastName'], $row['bookCount']);
        }
        return $authors;
    }

    public function getById(int $id): ?DomainAuthor
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("SELECT a.id, a.firstName, a.lastName, COUNT(b.id) as bookCount
                                            FROM Authors a
                                            LEFT JOIN Books b ON a.id = b.authorId
                                            WHERE a.id = :id
                                            GROUP BY a.id, a.firstName, a.lastName");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new DomainAuthor($row['id'], $row['firstName'], $row['lastName'], $row['bookCount']) : null;
    }

    public function create(string $firstName, string $lastName): DomainAuthor
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("INSERT INTO Authors (firstName, lastName) VALUES (:firstName, :lastName)");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName]);
        $id = DatabaseConnection::getInstance()->getConnection()->lastInsertId();
        return new DomainAuthor($id, $firstName, $lastName);
    }

    public function update(int $id, string $firstName, string $lastName): ?DomainAuthor
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("UPDATE Authors SET firstName = :firstName, lastName = :lastName WHERE id = :id");
        $stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'id' => $id]);
        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $stmt = DatabaseConnection::getInstance()->getConnection()->prepare("DELETE FROM Authors WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
