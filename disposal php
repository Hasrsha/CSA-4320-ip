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
$dbname = "waste_disposal";
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Ensure the table exists
$conn->query("CREATE TABLE IF NOT EXISTS waste_disposal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disposal_method VARCHAR(50) NOT NULL,
    quantity FLOAT NOT NULL,
    disposal_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $disposal_method = $_POST['disposal_method'];
    $quantity = $_POST['quantity'];
    $disposal_date = $_POST['date'];

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO waste_disposal (disposal_method, quantity, disposal_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $disposal_method, $quantity, $disposal_date);

    if ($stmt->execute()) {
        echo "<p>Data saved successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch data to display
$result = $conn->query("SELECT * FROM waste_disposal ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Disposal Module</title>
    <link rel="stylesheet" href="style7.css">
</head>
<body>
    <header>
        <h1>Waste Disposal</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <form action="disposal.php" method="POST">
            <label for="disposal_method">Disposal Method:</label>
            <select id="disposal_method" name="disposal_method" required>
                <option value="landfill">Landfill</option>
                <option value="incineration">Incineration</option>
                <option value="composting">Composting</option>
                <option value="recycling">Recycling</option>
                <option value="other">Other</option>
            </select>

            <label for="quantity">Quantity (in kg):</label>
            <input type="number" id="quantity" name="quantity" step="0.01" required>

            <label for="date">Date of Disposal:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit">Submit</button>
        </form>
    </section>
    <section>
        <h2>Disposal Records</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Disposal Method</th>
                    <th>Quantity (kg)</th>
                    <th>Disposal Date</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['disposal_method']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['disposal_date']}</td>
                            <td>{$row['created_at']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data available</td></tr>";
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
