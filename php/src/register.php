<?php
// Get environment variables
$servername = getenv('DB_HOST');
$db_username = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');
$table_name = getenv('MYSQL_TABLE');

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);
$conn->set_charset("utf8"); // Set the character set to UTF-8

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $category = $_POST["category"];

    // Validate input (add more validation as needed)
    if (empty($username) || empty($password) || empty($category)) {
        die("Please fill in all fields.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO $table_name (username, password, category) VALUES (?, ?, ?)");
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $username, $hashedPassword, $category);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['registration_success'] = true; // Set a success message
        header("Location: login.html"); 
        exit();
    } else {
        die("Registration failed: " . $stmt->error);
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close();
?>

