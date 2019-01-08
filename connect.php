<?php
$servername = "localhost";
$username = "database_stock";
$password = "88888888";
$dbname = "database_stock";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?> 