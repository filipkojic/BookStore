<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link rel="stylesheet" href="/Presentation/Public/css/booklist.css">
</head>
<body>

<div class="container">

    <h1 id="head1">Book List</h1>
    <div class="container2">
        <div class="book">Book</div>
        <div class="actions">Actions</div>
    </div>

    <hr/>

    <div class="book-list">
        <?php foreach ($books as $book): ?>
            <div class="book-item">
                <div class="book-details">
                    <span class="book-info"><?= htmlspecialchars($book->getName()) . ' (' . htmlspecialchars($book->getYear()) . ')' ?></span>
                </div>
                <div class="book-actions">
                    <a href="/editBook/<?= $book->getId(); ?>" class="edit">Edit</a>
                    <a href="/deleteBook/<?= $book->getId(); ?>" class="delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

        <hr/>

        <div class="add-book">
            <form action="/addBook" method="POST">
                <input type="hidden" name="authorId" value="<?= $authorId; ?>" />
                <button type="submit" class="add">+</button>
            </form>
        </div>

    </div>
</div>

</body>
</html>
