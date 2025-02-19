<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $suffix = $_POST['suffix'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $school = $_POST['school'];
    $status = $_POST['status'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: signup_form.php?error=Passwords do not match");
        exit;
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        header("Location: signup_form.php?error=Username or email already exists. Please choose a different one.");
        exit;
    } else {
        try {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO accounts (firstname, lastname, middlename, suffix, username, password, email, phone_number, school, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $middlename, $suffix, $username, $hashed_password, $email, $phone_number, $school, $status]);

            // Create a new table for the user
            $userTable = $username . "_records";
            $pdo->exec("CREATE TABLE $userTable (
                id INT AUTO_INCREMENT PRIMARY KEY,
                date_time DATETIME DEFAULT CURRENT_TIMESTAMP,
                activity_type VARCHAR(255),
                activity_info TEXT
            )");

            // Redirect to index.php for login
            header("Location: index.php?success=Account created successfully! Please log in.");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>