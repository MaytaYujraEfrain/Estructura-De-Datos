<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bookId = intval($_GET['id']);

$sql = "DELETE FROM books WHERE id = $bookId";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Book deleted successfully"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}

$conn->close();
?>
