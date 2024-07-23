<?php
session_start();
include "./includes/data.php";

if (!isset($_SESSION['authors'])) {
    $_SESSION['authors'] = $authors;
}
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = $books;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/authorList.css">
</head>
<body>

<div class="container">

    <h1 id="head1">Author list</h1>
    <div class="container2">
        <div class="author">Author</div>
        <div class="books">Books</div>
        <div class="actions">Actions</div>
    </div>

    <hr/>

    <div class="author-list">
        <?php foreach ($_SESSION['authors'] as $author): ?>
            <div class="author-item">
                <img src="./images/default-avatar.jpg" alt="Avatar" class="avatar">
                <div class="author-details">
                    <span class="name"><?= htmlspecialchars($author['first_name']) . ' ' . htmlspecialchars($author['last_name']) ?></span>
                </div>
                <div class="author-books">
                    <span class="book-count"><?= htmlspecialchars($author['book_count']) ?></span>
                </div>
                <div class="author-actions">
                    <a href="./pages/editAuthor.php?id=<?= $author['id'] ?>" class="edit">Edit</a>
                    <a href="./pages/deleteAuthor.php?id=<?= $author['id'] ?>" class="delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

        <hr/>

        <div class="add-author">
            <a href="./pages/addAuthor.php" class="add">+</a>
        </div>

    </div>
</body>
</html>
