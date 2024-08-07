<?php

namespace Filip\Bookstore\Business\DomainModels;

/**
 * Class DomainBook
 *
 * Represents a book with a name, publication year, and author ID.
 */
class DomainBook extends AbstractEntity
{
    /**
     * DomainBook constructor.
     *
     * @param int $id
     * @param string $name
     * @param int $year
     * @param int $authorId
     */
    public function __construct(
        private int    $id,
        private string $name,
        private int    $year,
        private int    $authorId
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * Converts the book to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'authorId' => $this->authorId
        ];
    }
}
