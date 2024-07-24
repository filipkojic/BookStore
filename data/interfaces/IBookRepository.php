<?php
interface IBookRepository {
    public function getAll();
    public function getById($id);
    public function create($name, $year, $author_id);
    public function update($id, $name, $year);
    public function delete($id);

    public function getBooksByAuthorId($author_id);
}
?>
