<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the database<br>";
}
?>
