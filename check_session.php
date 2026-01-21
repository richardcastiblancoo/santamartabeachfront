<?php
session_start();
echo "<h1>Session Debug</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

include 'auth/conexion_be.php';
$id = $_SESSION['id'];
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

echo "<h1>Database User Data</h1>";
echo "<pre>";
print_r($user);
echo "</pre>";

// Check column length
$result = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'imagen'");
$row = $result->fetch_assoc();
echo "<h1>Column Info</h1>";
echo "<pre>";
print_r($row);
echo "</pre>";
?>