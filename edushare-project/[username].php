<?php
// This file is dynamically created for user activity logging based on the username.
// Replace [username] with the actual username during sign-up.

require_once 'db_connection.php';

// Function to log user activity
function logUserActivity($username, $activityType, $activityInfo) {
    global $pdo;

    // Prepare the SQL statement to insert activity
    $stmt = $pdo->prepare("INSERT INTO `$username` (date_time, activity_type, activity_info) VALUES (NOW(), :activityType, :activityInfo)");
    
    // Bind parameters
    $stmt->bindParam(':activityType', $activityType);
    $stmt->bindParam(':activityInfo', $activityInfo);
    
    // Execute the statement
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Example usage
// logUserActivity('example_username', 'Login', 'User logged in successfully.');
?>