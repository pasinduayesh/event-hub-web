<?php
// $servername = "localhost";
// $username = "riblumac_diraj";
// $password = "iEYn(Lrxe8;{";
// $database = "riblumac_eventhub";

$servername = "localhost";
$username = "root";
$password = "";
$database = "eventhub";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}