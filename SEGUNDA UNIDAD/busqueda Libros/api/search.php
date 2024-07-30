<?php
include 'config.php';

$id = $_POST['id'];

$sql = "SELECT * FROM books WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(null);
}

$conn->close();
?>
