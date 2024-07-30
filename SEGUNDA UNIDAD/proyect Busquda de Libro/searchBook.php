<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del libro desde la solicitud
$bookId = intval($_GET['id']);

// Preparar y ejecutar la consulta
$sql = "SELECT * FROM books WHERE id = $bookId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Devolver los datos del libro como JSON
    $book = $result->fetch_assoc();
    echo json_encode($book);
} else {
    // No se encontró el libro
    echo json_encode(["error" => "No se encontró el libro"]);
}

$conn->close();
?>
