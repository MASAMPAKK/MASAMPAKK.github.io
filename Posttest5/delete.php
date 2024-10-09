<?php
$host = 'localhost';
$dbname = 'csgoskin';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = $_GET['id'];

$query = "DELETE FROM gunskin WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);

echo "Gun skin deleted successfully.";
?>
