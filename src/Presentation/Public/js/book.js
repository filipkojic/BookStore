document.addEventListener('DOMContentLoaded', () => {
    const bookList = document.querySelector('.book-list');

    // Extract authorId from URL
    const urlPath = window.location.pathname;
    const pathParts = urlPath.split('/');
    const authorId = pathParts[pathParts.length - 1];

    async function loadBooks() {
        try {
            const response = await ajaxGet(`/getBooks/${authorId}`);
            bookList.innerHTML = '';
            response.books.forEach(book => {
                const bookElement = document.createElement('div');
                bookElement.classList.add('book-item');
                bookElement.innerHTML = `
                    <div class="book-details">
                        <span class="book-info">${book.title} (${book.year})</span>
                    </div>
                    <div class="book-actions">
                        <a href="/editBook/${book.id}" class="edit">Edit</a>
                        <button class="delete" data-id="${book.id}" data-title="${book.title}">Delete</button>
                    </div>
                `;
                bookList.appendChild(bookElement);
            });
        } catch (error) {
            console.error('Error loading books:', error);
        }
    }

    // bookList.addEventListener('click', async (event) => {
    //     if (event.target.classList.contains('delete-book')) {
    //         const bookId = event.target.dataset.id;
    //         await ajaxDelete(`/deleteBook/${bookId}`);
    //         loadBooks();
    //     }
    // });

    const showAddBookFormButton = document.getElementById('show-add-book-form');
    const addBookForm = document.getElementById('add-book-form');
    const saveBookButton = document.getElementById('save-book-button');

    // Show the add book form when the "+" button is clicked
    showAddBookFormButton.addEventListener('click', () => {
        if (addBookForm.style.display === 'none') {
            addBookForm.style.display = 'block';
        } else {
            addBookForm.style.display = 'none';
        }
    });

    saveBookButton.addEventListener('click', async () => {
        const title = document.getElementById('book-title').value;
        const year = document.getElementById('book-year').value;
        const authorId = document.getElementById('x').value;
        const data = JSON.stringify({title, year, authorId});
        try {
            await ajaxPost(`/addBookAjax`, data);
            await loadBooks();
            addBookForm.classList.add('hidden');
        } catch (error) {
            console.error('Error adding book:', error);
        }
    });



    const deleteBookDialog = document.getElementById('delete-book-dialog');
    const deleteBookMessage = document.getElementById('delete-book-message');
    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    const cancelDeleteButton = document.getElementById('cancel-delete-button');
    let bookIdToDelete = null;

    bookList.addEventListener('click', async (event) => {
        if (event.target.classList.contains('delete')) {
            bookIdToDelete = event.target.dataset.id;
            const bookTitle = event.target.dataset.title;
            deleteBookMessage.querySelector('strong').textContent = bookTitle;
            deleteBookDialog.style.display = 'block';
        }
    });

    confirmDeleteButton.addEventListener('click', async () => {
        if (bookIdToDelete) {
            try {
                await ajaxDelete(`/deleteBookAjax/${bookIdToDelete}`);
                await loadBooks();
                deleteBookDialog.style.display = 'none';
                bookIdToDelete = null;
            } catch (error) {
                console.error('Error deleting book:', error);
            }
        }
    });

    cancelDeleteButton.addEventListener('click', () => {
        deleteBookDialog.style.display = 'none';
        bookIdToDelete = null;
    });

    loadBooks();
});
