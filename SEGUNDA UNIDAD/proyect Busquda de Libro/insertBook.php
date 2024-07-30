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

// Obtener los datos del libro desde la solicitud
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$title = $data->title;
$author = $data->author;

// Preparar y ejecutar la consulta
$sql = "INSERT INTO books (id, title, author) VALUES ('$id', '$title', '$author')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Libro insertado correctamente"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}

$conn->close();
?>
