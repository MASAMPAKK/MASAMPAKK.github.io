<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $telp = $_POST['telp'];
    $email = $_POST['email'];
    $sandi = password_hash($_POST['sandi'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT email FROM pengguna WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email telah digunakan, silakan gunakan email lain.'); window.location.href = 'regis.php';</script>";
    } else {
        $stmt = $conn->prepare("SELECT telp FROM pengguna WHERE telp = ?");
        $stmt->bind_param("s", $telp);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Nomor telepon telah digunakan, silakan gunakan nomor telepon lain.'); window.location.href = 'regis.php';</script>";
        } else {

            $stmt = $conn->prepare("INSERT INTO pengguna (nama_lengkap, telp, email, sandi) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama_lengkap, $telp, $email, $sandi);

            if ($stmt->execute()) {
                echo "<script>alert('Registrasi berhasil!'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Registrasi gagal, coba lagi nanti.'); window.location.href = 'regis.php';</script>";
            }
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | EventHub</title>
    <link rel="stylesheet" href="styles/relog.css">
    <link rel="icon" href="assets/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <img src="assets/relog.jpg" alt="Background Image">
        </div>
        <div class="right-side">
            <h2>Buat Akun</h2>
            <form method="POST" action="regis.php">
                <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>

                <input type="tel" id="telp" name="telp" placeholder="Nomor Telepon" required>

                <input type="email" id="email" name="email" placeholder="Email" required>

                <div class="password-container">
                    <input type="password" id="sandi" name="sandi" placeholder="Sandi" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>          

                <button type="submit">Daftar</button>
                <p class="login-register">Sudah memiliki akun?
                    <a href="login.php">Login</a>
                </p>
            </form>
        </div>
    </div>
    <script src="js/relog.js"></script>
</body>
</html>
