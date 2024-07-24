<?php
require_once __DIR__ . '/../interfaces/IAuthorService.php';
require_once __DIR__ . '/../../data/interfaces/IAuthorRepository.php';
require_once __DIR__ . '/../../data/interfaces/IBookRepository.php';

class AuthorService implements IAuthorService {
    private $authorRepository;
    private $bookRepository;

    public function __construct(IAuthorRepository $authorRepository, IBookRepository $bookRepository) {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @return Author[]
     */
    public function getAllAuthors() {
        return $this->authorRepository->getAll();
    }

    public function getAuthorById($id) {
        return $this->authorRepository->getById($id);
    }

    public function addAuthor($firstName, $lastName) {
        return $this->authorRepository->create($firstName, $lastName);
    }

    public function updateAuthor($id, $firstName, $lastName) {
        return $this->authorRepository->update($id, $firstName, $lastName);
    }

    public function deleteAuthor($id) {
        $books = $this->bookRepository->getBooksByAuthorId($id);
        foreach ($books as $book) {
                $this->bookRepository->delete($book->getId());
        }
        return $this->authorRepository->delete($id);
    }
}
