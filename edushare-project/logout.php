<!-- filepath: /c:/xampp/htdocs/EduShare/edushare-project/src/user_activities/logout.php -->
<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;
?>