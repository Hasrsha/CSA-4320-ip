<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: admin.php"); // Redirect to the login page
exit;
?>
