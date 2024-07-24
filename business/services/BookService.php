<?php
require_once __DIR__ . '/../interfaces/IBookService.php';
require_once __DIR__ . '/../../data/interfaces/IBookRepository.php';
require_once __DIR__ . '/../../data/interfaces/IAuthorRepository.php';

class BookService implements IBookService {
    private $bookRepository;
    private $authorRepository;

    public function __construct(IBookRepository $bookRepository, IAuthorRepository $authorRepository) {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
    }

    public function getAllBooks(): array {
        return $this->bookRepository->getAll();
    }

    public function getBookById($id) {
        return $this->bookRepository->getById($id);
    }

    public function addBook($name, $year, $authorId) {
        $newBook = $this->bookRepository->create($name, $year, $authorId);
        $this->authorRepository->incrementBookCount($authorId);
        return $newBook;
    }

    public function updateBook($id, $name, $year) {
        return $this->bookRepository->update($id, $name, $year);
    }

    public function deleteBook($id) {
        $book = $this->bookRepository->getById($id);
        if ($book) {
            $this->bookRepository->delete($id);
            $this->authorRepository->decrementBookCount($book->getAuthorId());
        }
    }

    public function getBooksByAuthorId($author_id): array {
        return $this->bookRepository->getBooksByAuthorId($author_id);
    }
}

