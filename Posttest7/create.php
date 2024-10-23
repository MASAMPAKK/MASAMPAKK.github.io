<?php
$host = 'localhost';
$dbname = 'csgoskin';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis = $_POST['jenis'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO gunskin (jenis, nama, harga) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$jenis, $nama, $harga]);

    echo "New gun skin added successfully.";
}
?>
