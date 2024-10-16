<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "csgoskin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $jenis = $_POST['jenis'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];

        $sql = "INSERT INTO gunskin (jenis, nama, harga) VALUES ('$jenis', '$nama', '$harga')";
        $conn->query($sql);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $jenis = $_POST['jenis'];
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];

        $sql = "UPDATE gunskin SET jenis='$jenis', nama='$nama', harga='$harga' WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM gunskin WHERE id=$id";
        $conn->query($sql);
    }
}

$sql = "SELECT * FROM gunskin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage CS:GO Weapons</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Manage CS:GO Weapons</h1>
        <nav class="nav-links">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="crud.php">Manage Weapons</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h2>Weapon List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Jenis</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['jenis']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="jenis" value="<?php echo $row['jenis']; ?>" required>
                        <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required>
                        <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required>
                        <button type="submit" name="update">Update</button>
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <h2>Add New Weapon</h2>
        <form action="" method="POST">
            <label for="jenis">Jenis:</label>
            <input type="text" name="jenis" required>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" required>
            <label for="harga">Harga:</label>
            <input type="number" name="harga" required>
            <button type="submit" name="create">Create</button>
        </form>
    </div>

    <footer>
        <p>&copy;2309106042</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
