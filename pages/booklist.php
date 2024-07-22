<?php include "../includes/data.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link rel="stylesheet" href="../css/booklist.css">
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
                    <span class="book-info"><?= htmlspecialchars($book['name']) . ' (' . htmlspecialchars($book['year']) . ')' ?></span>
                </div>
                <div class="book-actions">
                    <a class="edit">Edit</a>
                    <a class="delete">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

        <hr/>

        <div class="add-book">
            <a href="add_book.php" class="add">+</a>
        </div>

    </div>
</div>

</body>
</html>
