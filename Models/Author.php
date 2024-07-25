<?php

/**
 * Class Author
 *
 * Represents an author with a first name, last name, and book count.
 */
class Author
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var int
     */
    private int $bookCount;

    /**
     * Author constructor.
     *
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(int $id, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->bookCount = 0;
    }

    /**
     * Creates an array of Author objects from a batch of data.
     *
     * @param array $batch
     * @return self[]
     */
    public static function fromBatch(array $batch): array
    {
        $authors = [];
        foreach ($batch as $item) {
            $authors[] = new Author($item['id'], $item['firstName'], $item['lastName']);
        }
        return $authors;
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
