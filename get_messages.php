<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_login.php';

if (!$conn) {
    die("Error: Database connection failed");
}

// Check for connection errors
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

$sql = "SELECT messages.id, messages.message, messages.timestamp, user_login.username 
        FROM messages 
        JOIN user_login ON messages.user_id = user_login.id 
        ORDER BY messages.timestamp DESC";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

$messages = array();
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(["messages" => $messages]);
?>
