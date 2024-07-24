<?php
require_once __DIR__ . '/../interfaces/IBookRepository.php';
require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/../../utilities/SessionManager.php';

class SessionBookRepository implements IBookRepository {
    private $books;
    private $session;

    public function __construct() {
        $this->session = SessionManager::getInstance();
        $books = $this->session->get('books');

        if (!$books) {
            $books = [
                (new Book(1, 'Book Name', 2001, 1))->toArray(),
                (new Book(2, 'Book Name 2', 2002, 2))->toArray(),
                (new Book(3, 'Book Name 3', 1997, 3))->toArray(),
                (new Book(4, 'Book Name 4', 2005, 1))->toArray()
            ];
            $this->session->set('books', $books);
        }

        $this->books = Book::fromBatch($books);
    }

    public function getAll() {
        return $this->books;
    }

    public function getById($id) {
        foreach ($this->books as $book) {
            if ($book->getId() == $id) {
                return $book;
            }
        }
        return null;
    }

    public function create($name, $year, $author_id) {
        $id = count($this->books) + 1;
        $newBook = new Book($id, $name, $year, $author_id);
        $this->books[] = $newBook;
        $this->updateSession();
        return $newBook;
    }

    public function update($id, $name, $year) {
        foreach ($this->books as $book) {
            if ($book->getId() == $id) {
                $book->setName($name);
                $book->setYear($year);
                $this->updateSession();
                return $book;
            }
        }
        return null;
    }

    public function delete($id) {
        foreach ($this->books as $key => $book) {
            if ($book->getId() == $id) {
                unset($this->books[$key]);
                $this->updateSession();
                return true;
            }
        }
        return false;
    }

    public function getBooksByAuthorId($author_id) {
        $authorBooks = [];
        foreach ($this->books as $book) {
            if ($book->getAuthorId() == $author_id) {
                $authorBooks[] = $book;
            }
        }
        return $authorBooks;
    }

    private function updateSession() {
        $this->session->set('books', array_map(function($book) {
            return $book->toArray();
        }, $this->books));
    }
}

