<?php

namespace Filip\Bookstore\Presentation\Models;

class BookInput
{
    private ?int $id;
    private string $name;
    private int $year;
    private int $authorId;

    public function __construct(?int $id, string $name, $year, int $authorId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->year = is_numeric($year) ? (int)$year : 0;
        $this->authorId = $authorId;

        $this->validate();
    }

    private function validate(): void
    {
        $errors = [];

        if (empty($this->name)) {
            $errors['name'] = "Name is required.";
        } elseif (strlen($this->name) > 250) {
            $errors['name'] = "Name must be less than 250 characters.";
        }

        if ($this->year <= 0) {
            $errors['year'] = "Year must be a positive number.";
        }

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}
