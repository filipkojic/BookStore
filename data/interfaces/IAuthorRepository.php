<?php
interface IAuthorRepository {
    /**
     * @return Author[]
     */
    public function getAll(): array;
    public function getById($id);
    public function create($firstName, $lastName);
    public function update($id, $firstName, $lastName);
    public function delete($id);

    public function incrementBookCount($authorId);
    public function decrementBookCount($authorId);
}
