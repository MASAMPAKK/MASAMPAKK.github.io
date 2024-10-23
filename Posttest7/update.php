<?php
$host = 'localhost';
$dbname = 'csgoskin';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $jenis = $_POST['jenis'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    $query = "UPDATE gunskin SET jenis = ?, nama = ?, harga = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$jenis, $nama, $harga, $id]);

    echo "Gun skin updated successfully.";
}
?>
