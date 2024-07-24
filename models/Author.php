<?php

class Author
{
    public $id;
    public $first_name;
    public $last_name;
    public $book_count;

    public function __construct($id, $first_name, $last_name, $book_count)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->book_count = $book_count;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getBookCount()
    {
        return $this->book_count;
    }

    /**
     * @param mixed $book_count
     */
    public function setBookCount($book_count): void
    {
        $this->book_count = $book_count;
    }

    /**
     *
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'bookCount' => $this->book_count
        ];
    }

    /**
     * @param array $batch
     *
     * @return self[]
     */
    public static function fromBatch(array $batch): array
    {
        $authors = [];

        foreach ($batch as $item) {
            $authors[] = new Author($item['id'], $item['firstName'], $item['lastName'], $item['bookCount']);
        }

        return $authors;
    }
}
