<?php

ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the login form
    $username = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Database connection parameters
    $servername = getenv('DB_HOST');
    $db_username = getenv('DB_USER');
    $db_password = getenv('DB_PASSWORD');
    $database = getenv('DB_NAME');
    $table_name= getenv('MYSQL_TABLE');
    $conn = new mysqli($servername, $db_username, $db_password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a query to retrieve the user's hashed password from the database
    $stmt = $conn->prepare("SELECT * FROM $table_name WHERE username = ?");
    if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      die("Error executing query: " . $conn->error);
    }


    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password using password_verify
        if (password_verify($inputPassword, $hashedPassword)) {
            // Authentication successful, redirect to welcome.php and pass the username as a query parameter
            header("Location: welcome.php?username=" . urlencode($username));
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>
