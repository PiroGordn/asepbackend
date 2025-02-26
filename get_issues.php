<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$database = "issues_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Ensure the table exists
$sql_create_table = "CREATE TABLE IF NOT EXISTS issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issue_text TEXT NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    solved TINYINT(1) DEFAULT 0, -- Ensure it defaults to 0 (false)
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_create_table);

// Fetch issues from the database, explicitly casting `solved` as an integer
$result = $conn->query("SELECT id, issue_text, name, address, CAST(solved AS UNSIGNED) AS solved, submitted_at FROM issues ORDER BY submitted_at DESC");

if ($result) {
    $issues = [];
    while ($row = $result->fetch_assoc()) {
        $row['solved'] = (int) $row['solved']; // Ensure it's treated as an integer in PHP
        $issues[] = $row;
    }
    echo json_encode($issues);
} else {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
}

$conn->close();
?>
