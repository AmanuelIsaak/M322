<?php
$servername = "localhost";
$username = "root";
$password = "root";
$db = "book";

global $conn;
$conn = mysqli_connect($servername, $username, $password, $db);

if ($conn->connect_error) {
    die(
        "Verbindung kann nicht hergestellt werden. Error: " .
            $conn->connect_error
    );
}

return $conn;
