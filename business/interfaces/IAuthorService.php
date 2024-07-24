<?php
interface IAuthorService {
    public function getAllAuthors();
    public function getAuthorById($id);
    public function addAuthor($firstName, $lastName);
    public function updateAuthor($id, $firstName, $lastName);
    public function deleteAuthor($id);
}
?>
