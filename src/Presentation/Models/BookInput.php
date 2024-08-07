<?php

namespace Filip\Bookstore\Presentation\Models;

/**
 * Class BookInput
 *
 * Validates the input data for books.
 */
class BookInput
{
    private string $name;
    private int $year;

    /**
     * BookInput constructor.
     *
     * @param string $name
     * @param int|string $year
     * @throws \Exception
     */
    public function __construct(string $name, $year)
    {
        $this->name = $name;
        $this->year = is_numeric($year) ? (int)$year : 0;

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

        if (empty($this->name)) {
            $errors['name'] = "Name is required.";
        } elseif (strlen($this->name) > 250) {
            $errors['name'] = "Name must be less than 250 characters.";
        }

        if ($this->year == 0 || $this->year < -5000 || $this->year > 999999) {
            $errors['year'] = "Year must be between -5000 and 999999, and cannot be 0.";
        }

        if (!empty($errors)) {
            throw new \Exception(json_encode($errors));
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }
}
