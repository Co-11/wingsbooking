<!-- divya -->


<?php
// db_connection.php

// Database credentials
$host = 'localhost';        // Hostname (usually 'localhost' for local development)
$username = 'root';         // MySQL username (default is 'root' for XAMPP/WAMP)
$password = '';             // MySQL password (leave empty if no password is set)
$db_name = 'webdata';      // Your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset to UTF-8 for better compatibility
$conn->set_charset("utf8");
?>