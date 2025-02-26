<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "issues_db");

if ($conn->connect_error) {
    echo json_encode(["message" => "Database Connection Failed"]);
    exit();
}

$id = $_POST['id'];

$stmt = $conn->prepare("UPDATE issues SET solved = 1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

echo json_encode(["message" => "✅ Issue marked as solved."]);

$conn->close();
?>
