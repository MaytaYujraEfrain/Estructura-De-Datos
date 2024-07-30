// Crear instancia del BST
const bst = new BinarySearchTree();

// Manejar la inserción de un nuevo libro
document.getElementById('bookForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id = parseInt(document.getElementById('bookId').value);
    const title = document.getElementById('bookTitle').value;
    const author = document.getElementById('bookAuthor').value;
    
    alert(`ID: ${id}, Title: ${title}, Author: ${author}`);
    
    fetch('api/insert.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `id=${id}&title=${title}&author=${author}`
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      displayBooks();
    });
  
    this.reset();
  });
  
  

// Manejar la búsqueda de un libro
document.getElementById("searchForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const id = parseInt(document.getElementById("searchId").value);

  // Buscar libro en la base de datos
  fetch("api/search.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id=${id}`,
  })
    .then((response) => response.json())
    .then((book) => {
      const resultDiv = document.getElementById("searchResult");
      if (book !== null) {
        resultDiv.innerHTML = `<p class="alert alert-success">Libro encontrado: ID: ${book.id}, Título: ${book.title}, Autor: ${book.author}</p>`;
      } else {
        resultDiv.innerHTML = `<p class="alert alert-danger">Libro no encontrado</p>`;
      }
    });

  this.reset();
});

// Mostrar todos los libros en la lista
function displayBooks() {
  fetch("api/list.php")
    .then((response) => response.json())
    .then((books) => {
      const bookList = document.getElementById("bookList");
      bookList.innerHTML = "";
      books.forEach((book) => {
        const li = document.createElement("li");
        li.className = "list-group-item";
        li.textContent = `ID: ${book.id}, Título: ${book.title}, Autor: ${book.author}`;
        bookList.appendChild(li);
      });
    });
}

// Cargar todos los libros al cargar la página
window.onload = function () {
  displayBooks();
};
