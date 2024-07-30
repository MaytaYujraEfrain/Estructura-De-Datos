<?php
include 'config.php';

$sql = "SELECT * FROM books ORDER BY id";
$result = $conn->query($sql);

$books = array();
while($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);

$conn->close();
?>
