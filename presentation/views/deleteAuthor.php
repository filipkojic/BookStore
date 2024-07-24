<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Author</title>
    <link rel="stylesheet" href="/presentation/public/css/deleteAuthor.css">
</head>
<body>

<div class="dialog-container">
    <div class="dialog">
        <div class="dialog-header">
            <h2>Delete Author</h2>
        </div>
        <div class="dialog-body">
            <p>You are about to delete the author '<strong><?php echo htmlspecialchars($author->getFirstName() . ' ' . htmlspecialchars($author->getLastName())); ?></strong>'. If you proceed with this action, the application will permanently delete all books related to this author.</p>
        </div>
        <div class="dialog-footer">
            <form action="/deleteAuthor/<?php echo $author->getId(); ?>" method="POST">
                <button type="submit" name="confirm_delete" class="delete-button">Delete</button>
                <button type="button" class="cancel-button" onclick="window.history.back();">Cancel</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
