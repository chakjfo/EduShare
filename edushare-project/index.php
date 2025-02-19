<?php
// index.php serves as the entry point for the EduShare application

// Include the database connection file
require_once 'db_connection.php';

// Start the session
session_start();

// Check if the user is logged in or not
$isLoggedIn = isset($_SESSION['username']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        // Redirect to dashboard
        header("Location: home.html");
        exit;
    } else {
        // Redirect back to login with error
        header("Location: index.php?error=Invalid username or password");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>EduShare - Login</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <style>
        html, body {
            position: relative;
            min-height: 100vh;
            background-color: #E1E8EE;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Fira Sans", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .form-container {
            background-color: #222;
            border-radius: 15px;
            padding: 20px;
            width: 300px;
            color: #fff;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
        }
        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <form action="index.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="signup_form.php">Sign Up</a> | <a href="forgot_password.php">Forgot Password?</a>
    </div>
</body>
</html>