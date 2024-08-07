<?php

namespace Filip\Bookstore\Presentation\Models;

/**
 * Class AuthorInput
 *
 * Validates the input data for authors.
 */
class AuthorInput
{
    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * AuthorInput constructor.
     *
     * @param string $firstName
     * @param string $lastName
     * @throws \Exception
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        $this->validate();
    }

    /**
     * Validates the input data.
     *
     * @throws \Exception if validation fails
     */
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

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
