<?php
$servername = "10.1.107.76";
$username = "eproc";
$password = "A5dp3PR0c";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>