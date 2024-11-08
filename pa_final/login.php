<?php
session_start();
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $sandi = $_POST['sandi'];

    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($sandi, $user['sandi'])) {
            $_SESSION['email'] = $email;

            if ($email == 'admin@gmail.com') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: beranda.php");
                exit();
            }
        } else {
            echo "
            <script>
            alert('Sandi salah!');
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('Tidak ada akun pengguna yang ditemukan dengan email tersebut.');
        </script>
        ";
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
    <title>Login | EventHub</title>
    <link rel="icon" href="assets/logo.png" />
    <link rel="stylesheet" href="styles/relog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <img src="assets/relog.jpg" alt="Background Image">
        </div>
        <div class="right-side">
            <h2>Login</h2>

            <form method="POST" action="login.php">
                <input type="email" id="email" name="email" placeholder="Email" required>

                <div class="password-container">
                    <input type="password" id="sandi" name="sandi" placeholder="Sandi" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>            

                <button type="submit">Login</button>
                <p class="login-register">Belum memiliki akun?
                    <a href="regis.php">Buat Akun</a>
                </p>
            </form>
        </div>
    </div>
    <script src="js/relog.js"></script>
</body>
</html>
