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

    const titleError = document.getElementById('titleError');
    const yearError = document.getElementById('yearError');

    function validateForm(title, year) {
        let isValid = true;
        titleError.style.display = 'none';
        yearError.style.display = 'none';

        if (!title || title.length > 250) {
            titleError.textContent = 'The title is required and must be less than 250 characters.';
            titleError.style.display = 'block';
            isValid = false;
        }

        const yearValue = parseInt(year, 10);
        if (!year || isNaN(yearValue) || yearValue === 0 || yearValue < -5000 || yearValue > 999999) {
            yearError.textContent = 'The year is required and must be between -5000 and 999999, and cannot be 0.';
            yearError.style.display = 'block';
            isValid = false;
        }

        return isValid;
    }

    const showAddBookFormButton = document.getElementById('showAddBookForm');
    const addBookForm = document.getElementById('addBookForm');
    const saveBookButton = document.getElementById('saveBookButton');
    const closeAddBookForm = document.getElementById('closeAddBookForm');

    // Show the add book form when the "+" button is clicked
    showAddBookFormButton.addEventListener('click', () => {
        addBookForm.classList.remove('hidden');
    });

    closeAddBookForm.addEventListener('click', () => {
        addBookForm.classList.add('hidden');
    });

    saveBookButton.addEventListener('click', async () => {
        const title = document.getElementById('bookTitle').value;
        const year = document.getElementById('bookYear').value;
        const authorId = document.getElementById('authorId').value;
        if (!validateForm(title, year)) {
            return;
        }
        const data = JSON.stringify({ title, year, authorId });
        try {
            await ajaxPost(`/addBookAjax`, data);
            await loadBooks();
            addBookForm.classList.add("hidden");
        } catch (error) {
            console.error('Error adding book:', error);
        }
    });

    const deleteBookDialog = document.getElementById('deleteBookDialog');
    const deleteBookMessage = document.getElementById('deleteBookMessage');
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');
    const cancelDeleteButton = document.getElementById('cancelDeleteButton');
    const closeDeleteBookDialog = document.getElementById('closeDeleteBookDialog');
    let bookIdToDelete = null;

    bookList.addEventListener('click', async (event) => {
        if (event.target.classList.contains('delete')) {
            bookIdToDelete = event.target.dataset.id;
            const bookTitle = event.target.dataset.title;
            deleteBookMessage.querySelector('strong').textContent = bookTitle;
            deleteBookDialog.classList.remove('hidden');
        }
    });

    confirmDeleteButton.addEventListener('click', async () => {
        if (bookIdToDelete) {
            try {
                await ajaxDelete(`/deleteBookAjax/${bookIdToDelete}`);
                await loadBooks();
                deleteBookDialog.classList.add('hidden');
                bookIdToDelete = null;
            } catch (error) {
                console.error('Error deleting book:', error);
            }
        }
    });

    cancelDeleteButton.addEventListener('click', () => {
        deleteBookDialog.classList.add('hidden');
        bookIdToDelete = null;
    });

    closeDeleteBookDialog.addEventListener('click', () => {
        deleteBookDialog.classList.add('hidden');
    });

    loadBooks();
});
