document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('bookContainer');

    // Extract authorId from URL
    const urlPath = window.location.pathname;
    const pathParts = urlPath.split('/');
    const authorId = pathParts[pathParts.length - 1];

    // Function to create and append a new element
    function createElement(tag, attributes = {}, textContent = '') {
        const element = document.createElement(tag);
        for (const [key, value] of Object.entries(attributes)) {
            element.setAttribute(key, value);
        }
        if (textContent) {
            element.textContent = textContent;
        }
        return element;
    }

    // Creating header
    const header = createElement('h1', { id: 'head1' }, 'DomainBook List');
    container.appendChild(header);

    // Creating container2 div
    const container2 = createElement('div', { class: 'container2' });
    const bookLabel = createElement('div', { class: 'book' }, 'DomainBook');
    const actionsLabel = createElement('div', { class: 'actions' }, 'Actions');
    container2.appendChild(bookLabel);
    container2.appendChild(actionsLabel);
    container.appendChild(container2);

    // Adding a horizontal rule
    container.appendChild(createElement('hr'));

    // Creating the book-list div
    const bookList = createElement('div', { class: 'book-list' });
    container.appendChild(bookList);

    // Adding another horizontal rule
    container.appendChild(createElement('hr'));

    // Creating the add-book div
    const addBookDiv = createElement('div', { class: 'add-book' });
    const addBookButton = createElement('button', { id: 'showAddBookForm' }, '+');
    addBookDiv.appendChild(addBookButton);
    container.appendChild(addBookDiv);

    // Creating the addBookForm modal
    const addBookForm = createElement('div', { id: 'addBookForm', class: 'modal hidden' });
    const addBookFormContent = createElement('div', { class: 'modal-content' });
    addBookFormContent.appendChild(createElement('span', { class: 'close-button', id: 'closeAddBookForm' }, '×'));
    addBookFormContent.appendChild(createElement('h2', {}, 'Add DomainBook'));
    addBookFormContent.appendChild(createElement('hr'));

    const form = createElement('form');
    form.appendChild(createElement('input', { type: 'hidden', name: 'authorId', id: 'authorId', value: authorId }));
    form.appendChild(createElement('label', { for: 'bookTitle' }, 'Title'));
    form.appendChild(createElement('input', { type: 'text', id: 'bookTitle', name: 'title' }));
    form.appendChild(createElement('span', { id: 'titleError', class: 'error-message' }));
    form.appendChild(createElement('label', { for: 'bookYear' }, 'Year'));
    form.appendChild(createElement('input', { type: 'text', id: 'bookYear', name: 'year' }));
    form.appendChild(createElement('span', { id: 'yearError', class: 'error-message' }));

    const buttonContainer = createElement('div', { class: 'button-container' });
    const saveBookButton = createElement('button', { type: 'button', id: 'saveBookButton' }, 'Save');
    buttonContainer.appendChild(saveBookButton);
    form.appendChild(buttonContainer);

    addBookFormContent.appendChild(form);
    addBookForm.appendChild(addBookFormContent);
    container.appendChild(addBookForm);

    // Creating the deleteBookDialog modal
    const deleteBookDialog = createElement('div', { id: 'deleteBookDialog', class: 'modal hidden' });
    const deleteBookDialogContent = createElement('div', { class: 'modal-content' });
    deleteBookDialogContent.appendChild(createElement('span', { class: 'close-button', id: 'closeDeleteBookDialog' }, '×'));

    const dialogHeader = createElement('div', { class: 'dialog-header' });
    dialogHeader.appendChild(createElement('h2', {}, 'Delete DomainBook'));
    deleteBookDialogContent.appendChild(dialogHeader);

    const dialogBody = createElement('div', { class: 'dialog-body' });
    const deleteBookMessage = createElement('p', { id: 'deleteBookMessage' }, 'You are about to delete the book ');
    const bookTitleElement = createElement('strong', { id: 'bookTitle' }, '');
    deleteBookMessage.appendChild(bookTitleElement);
    deleteBookMessage.appendChild(document.createTextNode('. If you proceed with this action, the application will permanently delete this book.'));
    dialogBody.appendChild(deleteBookMessage);
    deleteBookDialogContent.appendChild(dialogBody);

    const dialogFooter = createElement('div', { class: 'dialog-footer' });
    const confirmDeleteButton = createElement('button', { id: 'confirmDeleteButton', class: 'delete-button' }, 'Delete');
    const cancelDeleteButton = createElement('button', { type: 'button', class: 'cancel-button', id: 'cancelDeleteButton' }, 'Cancel');
    dialogFooter.appendChild(confirmDeleteButton);
    dialogFooter.appendChild(cancelDeleteButton);
    deleteBookDialogContent.appendChild(dialogFooter);

    deleteBookDialog.appendChild(deleteBookDialogContent);
    container.appendChild(deleteBookDialog);

    /**
     * Load books for the current author from the server.
     */
    async function loadBooks() {
        try {
            const response = await ajaxGet(`/getBooks/${authorId}`);
            bookList.innerHTML = '';
            response.books.forEach(book => {
                appendBookToDOM(book);
            });
        } catch (error) {
            console.error('Error loading books:', error);
        }
    }

    /**
     * Append a book to the DOM.
     *
     * @param {object} book - The book object containing id, title, and year.
     */
    function appendBookToDOM(book) {
        const bookElement = document.createElement('div');
        bookElement.classList.add('book-item');
        bookElement.setAttribute('data-id', book.id);
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
    }

    const titleError = document.getElementById('titleError');
    const yearError = document.getElementById('yearError');

    /**
     * Validate the book form input fields.
     *
     * @param {string} title - The title of the book.
     * @param {string} year - The year of the book.
     * @returns {boolean} - Returns true if the form is valid, otherwise false.
     */
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

    // Show the add book form when the "+" button is clicked
    addBookButton.addEventListener('click', () => {
        addBookForm.classList.remove('hidden');
    });

    // Close the add book form when the close button is clicked
    closeAddBookForm.addEventListener('click', () => {
        addBookForm.classList.add('hidden');
    });

    /**
     * Handle the save book button click event.
     */
    saveBookButton.addEventListener('click', async () => {
        const title = document.getElementById('bookTitle').value;
        const year = document.getElementById('bookYear').value;
        const authorId = document.getElementById('authorId').value;
        if (!validateForm(title, year)) {
            return;
        }
        const data = JSON.stringify({ title, year, authorId });
        try {
            const response = await ajaxPost(`/addBook`, data);
            appendBookToDOM(response.book); // Add the new book directly to the DOM
            addBookForm.classList.add("hidden");
            document.getElementById('bookTitle').value = '';
            document.getElementById('bookYear').value = '';
        } catch (error) {
            console.error('Error adding book:', error);
        }
    });

    /**
     * Handle the book list click event to show the delete confirmation dialog.
     */
    bookList.addEventListener('click', async (event) => {
        if (event.target.classList.contains('delete')) {
            bookIdToDelete = event.target.dataset.id;
            const bookTitle = event.target.dataset.title;
            document.querySelector('#deleteBookMessage strong').textContent = bookTitle;
            deleteBookDialog.classList.remove('hidden');
        }
    });

    /**
     * Handle the confirm delete button click event to delete the book.
     */
    confirmDeleteButton.addEventListener('click', async () => {
        if (bookIdToDelete) {
            try {
                await ajaxDelete(`/deleteBook/${bookIdToDelete}`);
                document.querySelector(`.book-item[data-id="${bookIdToDelete}"]`).remove(); // Remove the book from the DOM
                deleteBookDialog.classList.add('hidden');
                bookIdToDelete = null;
            } catch (error) {
                console.error('Error deleting book:', error);
            }
        }
    });

    /**
     * Handle the cancel delete button click event to close the delete confirmation dialog.
     */
    cancelDeleteButton.addEventListener('click', () => {
        deleteBookDialog.classList.add('hidden');
        bookIdToDelete = null;
    });

    /**
     * Handle the close delete dialog button click event to close the delete confirmation dialog.
     */
    closeDeleteBookDialog.addEventListener('click', () => {
        deleteBookDialog.classList.add('hidden');
    });

    // Load books when the page is loaded
    loadBooks();
});
