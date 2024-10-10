<?php

$servername = $_ENV["SERVERNAME"];
$username = $_ENV["USERNAME"];
$password = $_ENV["PASSWORT"];
$db = $_ENV["DATENBANK"];

global $conn;
$conn = mysqli_connect($servername, $username, $password, $db);

if ($conn->connect_error) {
    die(
        "Verbindung kann nicht hergestellt werden. Error: " .
            $conn->connect_error
    );
}

return $conn;
