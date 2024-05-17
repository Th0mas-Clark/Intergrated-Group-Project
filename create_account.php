<?php
session_start();
include 'logout.php';
include_once 'db_login.php';

// Initialize variables to store form field values
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize input
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input lengths
    if (strlen($name) <= 5) {
        $error_message = "Name must be more than 5 characters long.";
    } elseif (strlen($username) <= 8) {
        $error_message = "Username must be more than 8 characters long.";
    } elseif (strlen($password) <= 8) {
        $error_message = "Password must be more than 8 characters long.";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error_message = "Password must include at least one capital letter.";
    } elseif (!preg_match('/[\W]/', $password)) {
        $error_message = "Password must include at least one special character.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Connect to login database
        $db_login = db_login();
        
        // Check for duplicate username
        $stmt = $db_login->prepare("SELECT COUNT(*) FROM user_login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($username_count);
        $stmt->fetch();
        $stmt->close();

        // Check for duplicate name
        $stmt = $db_login->prepare("SELECT COUNT(*) FROM user_login WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($name_count);
        $stmt->fetch();
        $stmt->close();

        if ($username_count > 0) {
            $error_message = "The username is already taken. Please choose a different one.";
        } elseif ($name_count > 0) {
            $error_message = "The name is already taken. Please choose a different one.";
        } else {
            // Get the current timestamp
            $date_account_made = date('Y-m-d H:i:s');

            // SQL to insert user data into the database
            $stmt = $db_login->prepare("INSERT INTO user_login (name, username, password_hash, date_account_made) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $username, $hashed_password, $date_account_made);

            if ($stmt->execute()) {
                // Clear session variables after successful creation
                unset($_SESSION['name']);
                unset($_SESSION['username']);
                unset($_SESSION['password']);
                // Redirect to login.php after successful account creation
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
        // Close connection
        $db_login->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>REST API - Create Account</title>
    <script>
        function validateForm() {
            const name = document.getElementById('name').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorElement = document.getElementById('error-message');

            if (name.length <= 5) {
                errorElement.textContent = "Name must be more than 5 characters long.";
                return false;
            } else if (username.length <= 8) {
                errorElement.textContent = "Username must be more than 8 characters long.";
                return false;
            } else if (password.length <= 8) {
                errorElement.textContent = "Password must be more than 8 characters long.";
                return false;
            } else if (!/[A-Z]/.test(password)) {
                errorElement.textContent = "Password must include at least one capital letter.";
                return false;
            } else if (!/[\W]/.test(password)) {
                errorElement.textContent = "Password must include at least one special character.";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="return validateForm()">
            <h1>Create Account</h1>
            
            <?php if (isset($error_message)) { ?>
                <p id="error-message" style="color: red;"><?php echo $error_message; ?></p>
            <?php } else { ?>
                <p id="error-message" style="color: red;"></p>
            <?php } ?>

            <p>Name must be above 5 characters long.</p>
            <div class="input-box">
                <label for='name'>Name:</label>
                <input type='text' id='name' name='name' placeholder="Name" required>
                <i class='bx bxs-user'></i>
            </div>

            <br>
            <p> Username must be above 8 characters</p>
            <div class="input-box">
                <label for='username'>Username:</label>
                <input type='text' id='username' name='username' placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            
            <br>
            <p>Password must be at least 8 characters long, include at least one capitalized letter, and one special character.</p>
            <div class="input-box">
                <label for='password'>Password:</label>
                <input type='password' id='password' name='password' placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            
            <button type='submit' class='btn'>Create Account</button>
        </form>
        
        <div class="register-link">
            <p>Have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
