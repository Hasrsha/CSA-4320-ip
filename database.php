<?php
$servername = "localhost";  // Database server (use "localhost" if hosted locally)
$username = "root";         // Database username (default for local servers is "root")
$password = "";             // Database password (default is an empty string for XAMPP/WAMP)
$dbname = "solid_waste_management_system"; // Ensure the database name is correct

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
