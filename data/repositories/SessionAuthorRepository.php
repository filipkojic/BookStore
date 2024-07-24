<?php
require_once __DIR__ . '/../interfaces/IAuthorRepository.php';
require_once __DIR__ . '/../../models/Author.php';
require_once __DIR__ . '/../../utilities/SessionManager.php';

class SessionAuthorRepository implements IAuthorRepository {
    private $authors;
    private $session;

    public function __construct() {
        $this->session = SessionManager::getInstance();
        $authors = $this->session->get('authors');

        if (!$authors) {
            $authors = [
                (new Author(1, 'Pera', 'Peric', 2))->toArray(),
                (new Author(2, 'Mika', 'Mikic', 1))->toArray(),
                (new Author(3, 'Zika', 'Zikic', 1))->toArray(),
                (new Author(4, 'Nikola', 'Nikolic', 0))->toArray()
            ];
            $this->session->set('authors', $authors);
        }

        $this->authors = Author::fromBatch($authors);
    }

    public function getAll(): array {
        return $this->authors;
    }

    public function getById($id) {
        foreach ($this->authors as $author) {
            if ($author->getId() == $id) {
                return $author;
            }
        }
        return null;
    }

    public function create($firstName, $lastName) {
        $id = count($this->authors) + 1;
        $newAuthor = new Author($id, $firstName, $lastName, 0);
        $this->authors[] = $newAuthor;
        $this->updateSession();
        return $newAuthor;
    }

    public function update($id, $firstName, $lastName) {
        foreach ($this->authors as $author) {
            if ($author->getId() == $id) {
                $author->setFirstName($firstName);
                $author->setLastName($lastName);
                $this->updateSession();
                return $author;
            }
        }
        return null;
    }

    public function delete($id) {
        foreach ($this->authors as $key => $author) {
            if ($author->getId() == $id) {
                unset($this->authors[$key]);
                $this->updateSession();
                return true;
            }
        }
        return false;
    }

    public function incrementBookCount($authorId) {
        foreach ($this->authors as $author) {
            if ($author->getId() == $authorId) {
                $author->setBookCount($author->getBookCount() + 1);
                $this->updateSession();
                return;
            }
        }
    }

    public function decrementBookCount($authorId) {
        foreach ($this->authors as $author) {
            if ($author->getId() == $authorId) {
                $author->setBookCount($author->getBookCount() - 1);
                $this->updateSession();
                return;
            }
        }
    }

    private function updateSession() {
        $this->session->set('authors', array_map(function($author) {
            return $author->toArray();
        }, $this->authors));
    }
}

