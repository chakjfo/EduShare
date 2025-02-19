<!-- filepath: /c:/xampp/htdocs/EduShare/edushare-project/forgot_password.php -->
<!DOCTYPE html>
<html>
<head>
    <title>EduShare - Forgot Password</title>
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
            width: 350px;
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Forgot Password</h2>
        <?php if (isset($_GET['step']) && $_GET['step'] == 'reset'): ?>
            <form action="forgot_password.php" method="post">
                <input type="hidden" name="username_or_email" value="<?php echo htmlspecialchars($_GET['username_or_email']); ?>">
                <input type="text" name="code" placeholder="Enter Code" required>
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        <?php else: ?>
            <form action="forgot_password.php" method="post">
                <input type="text" name="username_or_email" placeholder="Username or Email" required>
                <button type="submit" name="send_code">Send Code</button>
            </form>
        <?php endif; ?>
        <a href="index.php">Login</a>
    </div>
</body>
</html>

<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['send_code'])) {
        $username_or_email = $_POST['username_or_email'];

        // Check if username or email exists
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?");
        $stmt->execute([$username_or_email, $username_or_email]);
        $user = $stmt->fetch();

        if ($user) {
            // Generate a unique code
            $code = rand(100000, 999999);

            // Store the code in the database
            $stmt = $pdo->prepare("UPDATE accounts SET reset_code = ? WHERE username = ? OR email = ?");
            $stmt->execute([$code, $username_or_email, $username_or_email]);

            // Send the code to the user's email
            $email = $user['email'];
            mail($email, "Password Reset Code", "Your password reset code is: $code");

            // Redirect to reset password step
            header("Location: forgot_password.php?step=reset&username_or_email=$username_or_email");
            exit;
        } else {
            echo "No account found with that username or email.";
        }
    } elseif (isset($_POST['reset_password'])) {
        $username_or_email = $_POST['username_or_email'];
        $code = $_POST['code'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            echo "Passwords do not match.";
            exit;
        }

        // Check if the code is correct
        $stmt = $pdo->prepare("SELECT * FROM accounts WHERE (username = ? OR email = ?) AND reset_code = ?");
        $stmt->execute([$username_or_email, $username_or_email, $code]);
        $user = $stmt->fetch();

        if ($user) {
            // Update the user's password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE accounts SET password = ?, reset_code = NULL WHERE (username = ? OR email = ?)");
            $stmt->execute([$hashed_password, $username_or_email, $username_or_email]);

            // Redirect to index.php for login
            header("Location: index.php?success=Your password has been reset successfully. Please log in.");
            exit;
        } else {
            echo "Invalid code.";
        }
    }
}
?>