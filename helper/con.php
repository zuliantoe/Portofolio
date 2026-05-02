<?php

// Koneksi ke database MySQL dengan mysqli
// Gunakan 127.0.0.1 agar PHP terhubung lewat TCP, bukan mencari Unix socket
// dari host "localhost" yang bisa berbeda di Herd/Valet.
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "company_profile";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 3306);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}     

// Koneksi ke database MySQL dengan PDO
try {
    $pdo = new PDO("mysql:host=$servername;port=3306;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
