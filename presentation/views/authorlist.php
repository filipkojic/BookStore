<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author List</title>
    <link rel="stylesheet" href="/presentation/public/css/authorList.css">
</head>
<body>

<div class="container">
    <h1 id="head1">Author List</h1>
    <div class="container2">
        <div class="author">Author</div>
        <div class="books">Books</div>
        <div class="actions">Actions</div>
    </div>

    <hr/>

    <div class="author-list">

        <?php foreach ($authors as $author): ?>
            <div class="author-item">
                <img src="/presentation/public/img/default-avatar.jpg" alt="Avatar" class="avatar">
                <div class="author-details">
                    <span class="name"><a href="/books/<?php echo $author->getId(); ?>"><?php echo $author->getFirstName() . ' ' . $author->getLastName(); ?></a></span>
                </div>
                <div class="author-books">
                    <span class="book-count"><?php echo $author->getBookCount(); ?></span>
                </div>
                <div class="author-actions">
                    <a href="/editAuthor/<?php echo $author->getId(); ?>" class="edit">Edit</a>
                    <a href="/deleteAuthor/<?php echo $author->getId(); ?>" class="delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

        <hr/>

        <div class="add-author">
            <a href="/addAuthor" class="add">+</a>
        </div>
    </div>
</div>

</body>
</html>
