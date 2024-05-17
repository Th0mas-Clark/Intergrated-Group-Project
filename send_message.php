<?php
session_start();
include 'db_login.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username']) && isset($_POST['message'])) {
        $username = $_SESSION['username'];
        $message = $conn->real_escape_string($_POST['message']);

        // Fetch user_id based on the username
        $stmt = $conn->prepare("SELECT id FROM user_login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];

            // Insert the message with the user_id
            $stmt = $conn->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $message);
            if ($stmt->execute()) {
                echo "Message sent successfully";
            } else {
                echo "Error executing insert query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: User not found";
        }
    } else {
        echo "Error: Missing session data or message";
    }
} else {
    echo "Error: Invalid request method";
}

$conn->close();
?>