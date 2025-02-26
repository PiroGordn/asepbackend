<?php
header('Content-Type: application/json');

$search_query = $_GET['query'] ?? '';

if (empty($search_query)) {
    echo json_encode(["error" => "No search query provided."]);
    exit();
}

// Run Python script to fetch tweets
$output = shell_exec("python search_twitter.py " . escapeshellarg($search_query));

$tweets = json_decode($output, true);

// Return tweets as JSON
echo json_encode(["tweets" => $tweets ?: ["No relevant tweets found!"]]);
?>
