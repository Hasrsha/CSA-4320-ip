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
$dbname = "waste_segregation";
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Ensure the table exists
$conn->query("CREATE TABLE IF NOT EXISTS waste_segregation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL,
    material VARCHAR(255) NOT NULL,
    quantity FLOAT NOT NULL,
    segregation_date DATE NOT NULL
)");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $material = $_POST['material'];
    $quantity = $_POST['quantity'];
    $segregation_date = $_POST['segregation_date'];

    // Prepare SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO waste_segregation (category, material, quantity, segregation_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $category, $material, $quantity, $segregation_date);

    if ($stmt->execute()) {
        echo "<p>Data saved successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch data to display
$result = $conn->query("SELECT * FROM waste_segregation ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Segregation Module</title>
    <link rel="stylesheet" href="style8.css">
</head>
<body>
    <header>
        <h1>Waste Segregation</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <form action="segregation.php" method="POST">
            <label for="category">Waste Category:</label>
            <select id="category" name="category" required>
                <option value="organic">Organic</option>
                <option value="recyclable">Recyclable</option>
                <option value="hazardous">Hazardous</option>
                <option value="non-recyclable">Non-Recyclable</option>
            </select>

            <label for="material">Type of Material:</label>
            <input type="text" id="material" name="material" placeholder="Enter material type" required>

            <label for="quantity">Quantity (in kg):</label>
            <input type="number" id="quantity" name="quantity" step="0.01" placeholder="Enter quantity" required>

            <label for="segregation_date">Date of Segregation:</label>
            <input type="date" id="segregation_date" name="segregation_date" required>

            <button type="submit">Submit</button>
        </form>
    </section>
    <section>
        <h2>Submitted Data</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Material</th>
                    <th>Quantity (kg)</th>
                    <th>Segregation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['category']}</td>
                            <td>{$row['material']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['segregation_date']}</td>
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
