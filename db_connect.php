<?php
$servername = "localhost";
$username = "admin";
$password = "Afpa1234";
$database = "categorie_dp";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
