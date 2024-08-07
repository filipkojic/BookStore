<?php

namespace Filip\Bookstore\Business\DomainModels;

/**
 * Class DomainAuthor
 *
 * Represents an author with a first name, last name, and book count.
 */
class DomainAuthor extends AbstractEntity
{
    /**
     * DomainAuthor constructor.
     *
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param int $bookCount
     */
    public function __construct(
        private int    $id,
        private string $firstName,
        private string $lastName,
        private int    $bookCount = 0
    )
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return int
     */
    public function getBookCount(): int
    {
        return $this->bookCount;
    }

    /**
     * @param int $bookCount
     */
    public function setBookCount(int $bookCount): void
    {
        $this->bookCount = $bookCount;
    }

    /**
     * Converts the author to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName
        ];
    }
}
