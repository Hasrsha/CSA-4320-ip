<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin.php"); // Redirect to the admin login page
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <!-- <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1> -->
    <h2>Modules</h2>
    <ul>
        <li><a href="generation.php">Waste Generation</a></li>
        <li><a href="collection.php">Waste Collection</a></li>
        <li><a href="segregation.php">Waste Segregation</a></li>
        <li><a href="registration.php">Waste Registration</a></li>
        <li><a href="disposal.php">Waste Disposal</a></li>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>
