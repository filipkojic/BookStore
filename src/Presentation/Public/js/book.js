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
                        <button class="delete" data-id="${book.id}">Delete</button>
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

    loadBooks();
});
