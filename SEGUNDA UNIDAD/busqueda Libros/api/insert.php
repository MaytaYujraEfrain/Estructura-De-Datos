<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];

    echo "Received data - ID: $id, Title: $title, Author: $author<br>";

    $sql = "INSERT INTO books (id, title, author) VALUES ('$id', '$title', '$author')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.<br>";
}

$conn->close();
?>
