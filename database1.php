<?php
$servername = "localhost"; // Database server (usually localhost)
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "solid_waste_management_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
