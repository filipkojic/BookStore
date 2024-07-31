<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link rel="stylesheet" href="/src/Presentation/Public/css/booklist.css">
</head>
<body>

<div class="container">

    <h1 id="head1">Book List</h1>
    <div class="container2">
        <div class="book">Book</div>
        <div class="actions">Actions</div>
    </div>

    <hr/>

    <div class="book-list"></div>

    <hr/>

    <div class="add-book">
        <button id="showAddBookForm">+</button>
    </div>

    <div id="addBookForm" class="modal hidden">
        <div class="modal-content">
            <span class="close-button" id="closeAddBookForm">&times;</span>
            <h2>Add Book</h2>
            <hr>
            <form>
                <input type="hidden" name="authorId" id="authorId" value="<?php echo htmlspecialchars($authorId); ?>" />
                <label for="bookTitle">Title</label>
                <input type="text" id="bookTitle" name="title">
                <span id="titleError" class="error-message"></span>
                <label for="bookYear">Year</label>
                <input type="text" id="bookYear" name="year">
                <span id="yearError" class="error-message"></span>
                <div class="button-container">
                    <button type="button" id="saveBookButton">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteBookDialog" class="modal hidden">
        <div class="modal-content">
            <span class="close-button" id="closeDeleteBookDialog">&times;</span>
            <div class="dialog-header">
                <h2>Delete Book</h2>
            </div>
            <div class="dialog-body">
                <p id="deleteBookMessage">You are about to delete the book '<strong id="bookTitle"></strong>'. If you proceed with this action, the application will permanently delete this book.</p>
            </div>
            <div class="dialog-footer">
                <button id="confirmDeleteButton" class="delete-button">Delete</button>
                <button type="button" class="cancel-button" id="cancelDeleteButton">Cancel</button>
            </div>
        </div>
    </div>

</div>
<script src="/src/Presentation/Public/js/ajax.js"></script>
<script src="/src/Presentation/Public/js/book.js"></script>
</body>
</html>
