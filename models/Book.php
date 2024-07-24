<?php

class Book {
    public $id;
    public $name;
    public $year;
    public $author_id;

    public function __construct($id, $name, $year, $author_id) {
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->author_id = $author_id;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * @param mixed $author_id
     */
    public function setAuthorId($author_id): void
    {
        $this->author_id = $author_id;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'year' => $this->year,
            'authorId' => $this->author_id
        ];
    }

    public static function fromBatch(array $batch): array {
        $books = [];

        foreach ($batch as $item) {
            $books[] = new Book($item['id'], $item['name'], $item['year'], $item['authorId']);
        }

        return $books;
    }

}
?>
