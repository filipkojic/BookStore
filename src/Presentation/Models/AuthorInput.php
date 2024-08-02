<?php

namespace Filip\Bookstore\Presentation\Models;

class AuthorInput
{
    private ?int $id;
    private string $firstName;
    private string $lastName;
    private int $bookCount = 0;

    public function __construct(?int $id, string $firstName, string $lastName, int $bookCount = 0)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->bookCount = $bookCount;

        $this->validate();
    }

    private function validate(): void
    {
        $errors = [];

        if (empty($this->firstName)) {
            $errors['firstName'] = "First name is required.";
        } elseif (strlen($this->firstName) > 100) {
            $errors['firstName'] = "First name must be less than 100 characters.";
        }

        if (empty($this->lastName)) {
            $errors['lastName'] = "Last name is required.";
        } elseif (strlen($this->lastName) > 100) {
            $errors['lastName'] = "Last name must be less than 100 characters.";
        }

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBookCount(): int
    {
        return $this->bookCount;
    }
}
