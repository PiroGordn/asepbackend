<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$database = "issues_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["message" => "Database Connection Failed"]);
    exit();
}

$conn->query("CREATE TABLE IF NOT EXISTS issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issue_text TEXT NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    solved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$issue_text = $_POST['issue_text'];
$name = $_POST['name'];
$address = $_POST['address'];

if (empty($issue_text) || empty($name) || empty($address)) {
    echo json_encode(["message" => "⚠️ Please fill in all fields."]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO issues (issue_text, name, address) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $issue_text, $name, $address);
$stmt->execute();
$stmt->close();

echo json_encode(["message" => "✅ Issue submitted successfully."]);

$conn->close();
?>
