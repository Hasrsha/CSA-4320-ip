<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: user.html");
    exit;
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the database exists
$dbname = "waste_registration";
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Ensure the table exists
$conn->query("CREATE TABLE IF NOT EXISTS waste_registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id VARCHAR(50) NOT NULL,
    waste_type VARCHAR(50) NOT NULL,
    quantity FLOAT NOT NULL,
    location VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registration_id = $_POST['registration_id'];
    $waste_type = $_POST['waste_type'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO waste_registration (registration_id, waste_type, quantity, location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $registration_id, $waste_type, $quantity, $location);

    if ($stmt->execute()) {
        echo "<p>Waste registered successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch data to display
$result = $conn->query("SELECT * FROM waste_registration ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Registration Module</title>
    <link rel="stylesheet" href="style9.css">
</head>
<body>
    <header>
        <h1>Waste Registration</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <form action="registration.php" method="POST">
            <label for="registration_id">Registration ID:</label>
            <input type="text" id="registration_id" name="registration_id" required>

            <label for="waste_type">Type of Waste:</label>
            <select id="waste_type" name="waste_type" required>
                <option value="organic">Organic</option>
                <option value="recyclable">Recyclable</option>
                <option value="hazardous">Hazardous</option>
                <option value="other">Other</option>
            </select>

            <label for="quantity">Quantity (in kg):</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="location">Location of Waste:</label>
            <input type="text" id="location" name="location" required>

            <button type="submit">Register Waste</button>
        </form>
    </section>
    <section>
        <h2>Registered Waste</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Registration ID</th>
                    <th>Type of Waste</th>
                    <th>Quantity (kg)</th>
                    <th>Location</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['registration_id']}</td>
                            <td>{$row['waste_type']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['registration_date']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php
$conn->close();
?>
