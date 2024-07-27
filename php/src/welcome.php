<?php
$servername = getenv('DB_HOST');
$db_username = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');
$database = getenv('DB_NAME');
$table_name= getenv('MYSQL_TABLE');
// Create a new mysqli connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username from the query parameter
$username = $_GET['username'];

// Prepare and execute a query to retrieve user information based on the username
$stmt = $conn->prepare("SELECT category, username FROM $table_name WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the result
$userDetails = $result->fetch_assoc();


// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .welcome-container {
            max-width: 600px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            color: #666;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <?php
        if ($userDetails) {
            // Display the retrieved user information
            echo "<h1>Welcome, " . htmlspecialchars($username) . "!</h1>";
            echo "<p>Category: " . htmlspecialchars($userDetails['category']) . "</p>";
            echo "<p>Full Name: " . htmlspecialchars($userDetails['username']) . "</p>";
            echo "<p>This is a beautiful output after successful login!</p>";
            echo '<a href="logout.php">Logout</a>';
        } else {
            echo "User not found or an error occurred while fetching user information.";
        }
        ?>
    </div>
</body>
</html>
