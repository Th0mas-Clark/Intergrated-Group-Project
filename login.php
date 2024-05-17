<?php
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); 
ini_set('session.use_strict_mode', 1);

session_start();
include_once 'db_login.php';

// Set the limit and timeout for login attempts
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 300); // 5 minute timeout

// Initialize login attempts and timestamp if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['first_attempt_time'] = time();
}

// Reset the counter if timeout has passed
if (time() - $_SESSION['first_attempt_time'] > LOGIN_TIMEOUT) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['first_attempt_time'] = time();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $username = filter_var($_POST['username'], FILTER_UNSAFE_RAW);
    $password = $_POST['password'];

    if ($_SESSION['login_attempts'] < MAX_LOGIN_ATTEMPTS) {
        $db_login = db_login();

        $stmt = $db_login->prepare("SELECT username, password_hash FROM user_login WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($db_username, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        if ($hashed_password !== null && password_verify($password, $hashed_password)) {
            // Reset login attempts on successful login
            $_SESSION['login_attempts'] = 0;
            $_SESSION['first_attempt_time'] = time();

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login_attempts']++;
            $_SESSION['first_attempt_time'] = time(); // Update the first attempt time
            $error_message = "Incorrect username or password!";
        }
    } else {
        $error_message = "Too many login attempts. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>NBA LIVE STATS</title>
  </head>
  
  <body>
      <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h1>Login</h1>

            <?php if (isset($error_message)) { ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php } ?>

            <div class="input-box">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="create_account.php">Register</a></p>
            </div>
        </form>
      </div>
  </body>
</html>
