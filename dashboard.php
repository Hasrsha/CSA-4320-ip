<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style6.css">
</head>
<body>
    <header>
        <h1>Welcome to the Waste Management System</h1>
        <!-- <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p> -->
        <a href="logout.php" class="logout-button">Logout</a>
    </header>

    <section>
        <h2>Modules</h2>
        <ul class="module-list">
            <li><a href="generation.php">Waste Generation</a></li>
            <li><a href="collection.php">Waste Collection</a></li>
            <li><a href="segregation.php">Waste Segregation</a></li>
            <li><a href="registration.php">Waste Registration</a></li>
            <li><a href="disposal.php">Waste Disposal</a></li>
        </ul>
    </section>
</body>
</html>
