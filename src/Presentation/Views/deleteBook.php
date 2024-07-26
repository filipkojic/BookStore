<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/deleteBook.css">
</head>
<body>

<div class="dialog-container">
    <div class="dialog">
        <div class="dialog-header">
            <h2>Delete Book</h2>
        </div>
        <div class="dialog-body">
            <p>You are about to delete the book '<strong><?php echo htmlspecialchars($book->getName()); ?></strong>'. If you proceed with this action, the application will permanently delete this book.</p>
        </div>
        <div class="dialog-footer">
            <form action="/deleteBook/<?php echo $book->getId(); ?>" method="POST">
                <button type="submit" name="confirm_delete" class="delete-button">Delete</button>
                <button type="button" class="cancel-button" onclick="window.history.back();">Cancel</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
