<?php
interface IBookService {
    public function getAllBooks();
    public function getBookById($id);
    public function addBook($name, $year, $author_id);
    public function updateBook($id, $name, $year);
    public function deleteBook($id);

    public function getBooksByAuthorId($author_id);
}
?>
