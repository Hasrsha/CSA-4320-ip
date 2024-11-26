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
$dbname = "waste_management";
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Ensure the table exists
$conn->query("CREATE TABLE IF NOT EXISTS waste_collection (
    id INT AUTO_INCREMENT PRIMARY KEY,
    collection_point VARCHAR(255) NOT NULL,
    collector_name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    quantity FLOAT NOT NULL,
    collection_date DATE NOT NULL
)");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $collection_point = $_POST['collection_point'];
    $collector_name = $_POST['collector_name'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $collection_date = $_POST['collection_date'];

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO waste_collection (collection_point, collector_name, type, quantity, collection_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssds", $collection_point, $collector_name, $type, $quantity, $collection_date);

    if ($stmt->execute()) {
        echo "<p>Data saved successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch data to display
$result = $conn->query("SELECT * FROM waste_collection ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Collection Module</title>
    <link rel="stylesheet" href="style7.css">
</head>
<body>
    <header>
        <h1>Waste Collection</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <form action="collection.php" method="POST">
            <label for="collection-point">Collection Point:</label>
            <input type="text" id="collection-point" name="collection_point" required>

            <label for="collector-name">Collector's Name:</label>
            <input type="text" id="collector-name" name="collector_name" required>

            <label for="type">Type of Waste Collected:</label>
            <select id="type" name="type" required>
                <option value="organic">Organic</option>
                <option value="recyclable">Recyclable</option>
                <option value="hazardous">Hazardous</option>
                <option value="mixed">Mixed</option>
            </select>

            <label for="quantity">Quantity (in kg):</label>
            <input type="number" id="quantity" name="quantity" step="0.01" required>

            <label for="collection-date">Date of Collection:</label>
            <input type="date" id="collection-date" name="collection_date" required>

            <button type="submit">Submit</button>
        </form>
    </section>
    <section>
        <h2>Submitted Data</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Collection Point</th>
                    <th>Collector's Name</th>
                    <th>Type</th>
                    <th>Quantity (kg)</th>
                    <th>Collection Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['collection_point']}</td>
                            <td>{$row['collector_name']}</td>
                            <td>{$row['type']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['collection_date']}</td>
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
