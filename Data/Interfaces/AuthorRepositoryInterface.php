<?php

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
     * @return Author[] Array of Author objects.
     */
    public function getAll(): array;

    /**
     * Get author by ID.
     *
     * @param int $id Author ID.
     * @return Author|null Author object or null if not found.
     */
    public function getById(int $id): ?Author;

    /**
     * Create a new author.
     *
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author Newly created Author object.
     */
    public function create(string $firstName, string $lastName): Author;

    /**
     * Update an existing author.
     *
     * @param int $id Author ID.
     * @param string $firstName Author's first name.
     * @param string $lastName Author's last name.
     * @return Author|null Updated Author object or null if not found.
     */
    public function update(int $id, string $firstName, string $lastName): ?Author;

    /**
     * Delete an author.
     *
     * @param int $id Author ID.
     * @return bool True if deletion was successful, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Increment the book count for an author.
     *
     * @param int $authorId Author ID.
     */
    public function incrementBookCount(int $authorId): void;

    /**
     * Decrement the book count for an author.
     *
     * @param int $authorId Author ID.
     */
    public function decrementBookCount(int $authorId): void;
}
