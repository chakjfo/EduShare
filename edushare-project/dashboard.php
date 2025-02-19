<!-- filepath: /c:/xampp/htdocs/EduShare/edushare-project/dashboard.php -->
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>EduShare - Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    <style>
        html, body {
            position: relative;
            min-height: 100vh;
            background-color: #E1E8EE;
            display: flex;
            font-family: "Fira Sans", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .sidebar {
            background-color: #333;
            color: #fff;
            width: 200px;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar a {
            color: #4CAF50;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            flex-grow: 1;
        }
        .profile-info {
            background-color: #222;
            border-radius: 15px;
            padding: 20px;
            color: #fff;
        }
        .profile-info h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar</h2>
        <a href="#">Link 1</a>
        <a href="#">Link 2</a>
        <a href="#">Link 3</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <div class="profile-info">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>This is your profile information.</p>
            <!-- Add more profile information here -->
        </div>
    </div>
</body>
</html>