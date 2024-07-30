<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/booklist.css">
<!--    <link rel="stylesheet" href="/src/Presentation/Public/css/bookForm.css">-->
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



    </div>

    <hr/>

    <div class="add-book">
        <button id="show-add-book-form">+</button>
    </div>

    <div id="add-book-form" style="display: none;">
        <h2>Add Book</h2>
        <form>
            <input type="hidden" name="authorId" id= "x" value="<?php echo htmlspecialchars($authorId); ?>" />
            <label for="book-title">Title</label>
            <input type="text" id="book-title" name="title">
            <label for="book-year">Year</label>
            <input type="text" id="book-year" name="year">
            <button type="button" id="save-book-button">Save</button>
        </form>
    </div>

    <div id="delete-book-dialog" style="display: none;">
        <div class="dialog-container">
            <div class="dialog">
                <div class="dialog-header">
                    <h2>Delete Book</h2>
                </div>
                <div class="dialog-body">
                    <p id="delete-book-message">You are about to delete the book '<strong id="x"></strong>'. If you proceed with this action, the application will permanently delete this book.</p>
                </div>
                <div class="dialog-footer">
                    <button id="confirm-delete-button" class="delete-button">Delete</button>
                    <button type="button" class="cancel-button" id="cancel-delete-button">Cancel</button>
                </div>
            </div>
        </div>
    </div>


</div>
<script src="/src/Presentation/Public/js/ajax.js"></script>
<script src="/src/Presentation/Public/js/book.js"></script>
</body>
</html>
