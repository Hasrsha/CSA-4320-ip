<?php
session_start();

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
$dbname = "waste_generation";
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Ensure the table exists
$conn->query("CREATE TABLE IF NOT EXISTS waste_generation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    source VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    quantity FLOAT NOT NULL,
    date DATE NOT NULL
)");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $source = $_POST['source'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO waste_generation (source, type, quantity, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $source, $type, $quantity, $date);

    if ($stmt->execute()) {
        echo "<p>Data saved successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch data to display
$result = $conn->query("SELECT * FROM waste_generation ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Generation Module</title>
    <link rel="stylesheet" href="style5.css">
</head>
<body>
    <header>
        <h1>Waste Generation</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <form action="generation.php" method="POST">
            <label for="source">Source of Waste:</label>
            <input type="text" id="source" name="source" required>

            <label for="type">Type of Waste:</label>
            <select id="type" name="type" required>
                <option value="organic">Organic</option>
                <option value="recyclable">Recyclable</option>
                <option value="hazardous">Hazardous</option>
                <option value="other">Other</option>
            </select>

            <label for="quantity">Quantity (in kg):</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="date">Date of Generation:</label>
            <input type="date" id="date" name="date" required>

            <button type="submit">Submit</button>
        </form>
    </section>
    <section>
        <h2>Submitted Data</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Source</th>
                    <th>Type</th>
                    <th>Quantity (kg)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['source']}</td>
                            <td>{$row['type']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['date']}</td>
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
