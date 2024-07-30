<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      padding-top: 56px; /* 56px to account for fixed navbar */
      background-color: #f8f9fa; /* Color de fondo general */
    }
    .jumbotron {
      background-image: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh_For6tDV0L1w6xJOSv0xto7dBYfeZoVQ1AphvT_HOSdPKhAv2bC2-4OSckypfxuw_gb-RvCFSqeBRVAkJPQVJnzAxjNG7HxP80zbXbDKDjE2SX7cWZuPXZOMT8K82BAG9Yh4WcWOpoGk/s1600/paraambitos2.jpg'); /* Imagen de fondo para el jumbotron */
      background-size: cover;
      background-position: center;
      color: #ecf0f1; /* Color del texto del jumbotron */
      padding: 100px 0; /* Ajuste del padding para centrar el texto */
    }
    .card {
      margin-bottom: 20px;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.5rem;
    }
    .book-list .card {
      margin-bottom: 10px;
    }
    .edit-btn, .delete-btn {
      cursor: pointer;
    }
    .bg-primary {
      background-color: #3498db !important; /* Color de fondo de los encabezados */
    }
    .bg-danger {
      background-color: #e74c3c !important; /* Color de fondo del formulario de eliminar */
    }
    .navbar-dark .navbar-nav .nav-link {
      color: #ecf0f1; /* Color del texto del navbar */
    }
    .navbar-dark .navbar-nav .nav-link:hover {
      color: #ffffff; /* Color del texto del navbar al pasar el mouse */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Biblioteca</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#insert">Insert Book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#search">Search Book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#delete">Delete Book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#allbooks">All Books</a>
        </li>
      </ul>
    </div>
  </nav>
  
  <div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
      <h1 class="display-4">Sistema de gestión de biblioteca</h1>
      <p class="lead">Administre eficientemente los libros de su biblioteca con facilidad.</p>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-6" id="insert">
        <div class="card">
          <div class="card-header bg-primary text-white">
            Insert a New Book
          </div>
          <div class="card-body">
            <form id="bookForm">
              <div class="form-group">
                <label for="bookId">Book ID</label>
                <input type="number" class="form-control" id="bookId" placeholder="Enter Book ID" required>
              </div>
              <div class="form-group">
                <label for="bookTitle">Book Title</label>
                <input type="text" class="form-control" id="bookTitle" placeholder="Enter Book Title" required>
              </div>
              <div class="form-group">
                <label for="bookAuthor">Book Author</label>
                <input type="text" class="form-control" id="bookAuthor" placeholder="Enter Book Author" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Insert Book</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6" id="search">
        <div class="card">
          <div class="card-header bg-primary text-white">
            Search for a Book
          </div>
          <div class="card-body">
            <form id="searchForm">
              <div class="form-group">
                <label for="searchId">Book ID</label>
                <input type="number" class="form-control" id="searchId" placeholder="Enter Book ID" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Search Book</button>
            </form>
            <div id="searchResult" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6" id="delete">
        <div class="card">
          <div class="card-header bg-danger text-white">
            Delete a Book
          </div>
          <div class="card-body">
            <form id="deleteForm">
              <div class="form-group">
                <label for="deleteId">Book ID</label>
                <input type="number" class="form-control" id="deleteId" placeholder="Enter Book ID" required>
              </div>
              <button type="submit" class="btn btn-danger btn-block">Delete Book</button>
            </form>
            <div id="deleteResult" class="mt-3"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row book-list" id="allbooks">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header bg-primary text-white">
            All Books
          </div>
          <div class="card-body">
            <ul id="bookList" class="list-group"></ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    document.getElementById('bookForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const id = parseInt(document.getElementById('bookId').value);
      const title = document.getElementById('bookTitle').value;
      const author = document.getElementById('bookAuthor').value;
      fetch('insertBook.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, title, author })
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message);
        displayBooks();
        this.reset();
      })
      .catch(error => console.error('Error:', error));
    });

    document.getElementById('searchForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const id = parseInt(document.getElementById('searchId').value);
      fetch(`searchBook.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
          const resultDiv = document.getElementById('searchResult');
          if (data.error) {
            resultDiv.innerHTML = `<p class="alert alert-danger">${data.error}</p>`;
          } else {
            resultDiv.innerHTML = `<p class="alert alert-success">Book found: ID: ${data.id}, Title: ${data.title}, Author: ${data.author}</p>`;
          }
        })
        .catch(error => console.error('Error:', error));
      this.reset();
    });

    document.getElementById('deleteForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const id = parseInt(document.getElementById('deleteId').value);
      fetch(`deleteBook.php?id=${id}`, {
        method: 'DELETE'
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message);
        displayBooks();
      })
      .catch(error => console.error('Error:', error));
      this.reset();
    });

    function displayBooks() {
      fetch('getAllBooks.php')
        .then(response => response.json())
        .then(data => {
          const bookList = document.getElementById('bookList');
          bookList.innerHTML = '';
          data.forEach(book => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `ID: ${book.id}, Title: ${book.title}, Author: ${book.author}
              <div>
                <button class="btn btn-sm btn-info edit-btn mr-2" data-id="${book.id}">Edit</button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="${book.id}">Delete</button>
              </div>`;
            bookList.appendChild(li);
          });
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', displayBooks);

    // Example editBook function (needs implementation)
    document.getElementById('bookList').addEventListener('click', function (e) {
      if (e.target.classList.contains('edit-btn')) {
        const bookId = e.target.getAttribute('data-id');
        alert(`Implement edit functionality for book ID ${bookId}`);
      } else if (e.target.classList.contains('delete-btn')) {
        const bookId = e.target.getAttribute('data-id');
        if (confirm(`Are you sure you want to delete book ID ${bookId}?`)) {
          fetch(`deleteBook.php?id=${bookId}`, {
            method: 'DELETE'
          })
          .then(response => response.json())
          .then(data => {
            alert(data.message);
            displayBooks();
          })
          .catch(error => console.error('Error:', error));
        }
      }
    });
  </script>
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
