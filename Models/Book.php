<?php

/**
 * Class Book
 *
 * Represents a book with a name, publication year, and author ID.
 */
class Book
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $year;

    /**
     * @var int
     */
    private int $authorId;

    /**
     * Book constructor.
     *
     * @param int $id
     * @param string $name
     * @param int $year
     * @param int $authorId
     */
    public function __construct(int $id, string $name, int $year, int $authorId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->authorId = $authorId;
    }

    /**
     * Creates an array of Book objects from a batch of data.
     *
     * @param array $batch
     * @return self[]
     */
    public static function fromBatch(array $batch): array
    {
        $books = [];
        foreach ($batch as $item) {
            $books[] = new Book($item['id'], $item['name'], $item['year'], $item['authorId']);
        }
        return $books;
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
