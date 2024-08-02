<?php

namespace Filip\Bookstore\Business\Interfaces\RepositoryInterfaces;

use Filip\Bookstore\Business\DomainModels\DomainAuthor;

/**
 * Interface AuthorRepositoryInterface
 *
 * This interface defines the contract for author repository.
 */
interface AuthorRepositoryInterface
{
    /**
     * Get all authors.
     *
     * @return DomainAuthor[] Array of DomainAuthor objects.
     */
    public function getAll(): array;

    /**
     * Get author by ID.
     *
     * @param int $id DomainAuthor ID.
     * @return DomainAuthor|null DomainAuthor object or null if not found.
     */
    public function getById(int $id): ?DomainAuthor;

    /**
     * Create a new author.
     *
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor Newly created DomainAuthor object.
     */
    public function create(string $firstName, string $lastName): DomainAuthor;

    /**
     * Update an existing author.
     *
     * @param int $id DomainAuthor ID.
     * @param string $firstName DomainAuthor's first name.
     * @param string $lastName DomainAuthor's last name.
     * @return DomainAuthor|null Updated DomainAuthor object or null if not found.
     */
    public function update(int $id, string $firstName, string $lastName): ?DomainAuthor;

    /**
     * Delete an author.
     *
     * @param int $id DomainAuthor ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(int $id): bool;
}
