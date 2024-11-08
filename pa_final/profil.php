<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$query = "SELECT nama_lengkap, telp, email, foto_profil, id_pengguna FROM pengguna WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$id_pengguna = $user['id_pengguna'];

$pesanan_query = "
        SELECT data_regis.nama_event, data_regis.waktu_event, data_regis.tanggal_event, data_regis.lokasi_event, data_regis.jumlah_tiket, data_regis.tanggal_pemesanan
        FROM data_regis
        WHERE data_regis.id_pengguna = ?
    ";
$pesanan_stmt = $conn->prepare($pesanan_query);
$pesanan_stmt->bind_param("i", $id_pengguna);
$pesanan_stmt->execute();
$pesanan_result = $pesanan_stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $telp = $_POST['telp'];
    $email_baru = $_POST['email'];
    $foto_baru = $_FILES['foto_profil'];

    if ($email_baru != $email) {
        $check_email_query = "SELECT * FROM pengguna WHERE email = ?";
        $stmt_check = $conn->prepare($check_email_query);
        $stmt_check->bind_param("s", $email_baru);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            echo "<script>alert('Email sudah terdaftar, silahkan gunakan email lain.');window.location.href = 'profil.php';</script>";
            exit();
        }
    }

    if ($telp != $user['telp']) {
        $check_telp_query = "SELECT * FROM pengguna WHERE telp = ?";
        $stmt_check_telp = $conn->prepare($check_telp_query);
        $stmt_check_telp->bind_param("s", $telp);
        $stmt_check_telp->execute();
        $result_check_telp = $stmt_check_telp->get_result();
        if ($result_check_telp->num_rows > 0) {
            echo "<script>alert('Nomor telepon sudah terdaftar, silahkan gunakan nomor lain.');window.location.href = 'profil.php';</script>";
            exit();
        }
    }

    if (empty($error)) {
        if ($foto_baru['error'] == 0) {
            $max_size = 5 * 1024 * 1024; 
            if ($foto_baru['size'] > $max_size) {
                echo "<script>alert('Ukuran file terlalu besar. Maksimal ukuran file adalah 5 MB.');window.location.href = 'profil.php';</script>";
                exit();
            }

            $target_dir = "uploads/profil/";
            $target_file = $target_dir . basename($foto_baru["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $allowed_types = ["jpg", "jpeg", "png"];
            if (!in_array($imageFileType, $allowed_types)) {
                echo "<script>alert('File harus berupa gambar (JPG, JPEG, PNG)');window.location.href = 'profil.php';</script>";
                exit();
            } else {
                move_uploaded_file($foto_baru["tmp_name"], $target_file);
            }
        } else {
            $target_file = $user['foto_profil'];
        }

        if (empty($error)) {
            $update_query = "UPDATE pengguna SET nama_lengkap = ?, telp = ?, email = ?, foto_profil = ? WHERE email = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("sssss", $nama_lengkap, $telp, $email_baru, $target_file, $email);
            if ($stmt_update->execute()) {
                $_SESSION['email'] = $email_baru;
                echo "<script>alert('Data profil berhasil disimpan');window.location.href = 'profil.php';</script>";
                exit();
            } else {
                echo "<script>alert('Gagal menyimpan data profil.');window.location.href = 'profil.php';</script>";
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="styles/profil.css" />
    <link rel="icon" href="assets/logo.png" />
    <title>Profil | EventHub</title>
</head>

<body>
    <div class="container">
        <img src="<?php echo empty($user['foto_profil']) ? 'assets/default.png' : $user['foto_profil']; ?>" alt="Profile Image" class="profile-image">
        <form action="profil.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="foto_profil">Foto Profil</label>
                <input type="file" id="foto_profil" name="foto_profil" />
            </div>

            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required />
            </div>

            <div class="form-group">
                <label for="telp">Nomor Telepon</label>
                <input type="text" id="telp" name="telp" value="<?php echo htmlspecialchars($user['telp']); ?>" required />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required />
            </div>

            <div class="button-group">
                <button type="submit">Simpan</button>
                <button type="button" onclick="window.location.href='beranda.php';">Kembali ke Beranda</button>
            </div>
        </form>

        <h3>Histori Pemesanan</h3>
        <?php if ($pesanan_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama Event</th>
                        <th>Jumlah Tiket</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Tiket</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pesanan = $pesanan_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pesanan['nama_event']); ?></td>
                            <td><?php echo htmlspecialchars($pesanan['jumlah_tiket']); ?></td>
                            <td><?php echo htmlspecialchars($pesanan['tanggal_pemesanan']); ?></td>
                            <td>
                                <a class="lihat-btn" href="javascript:void(0)"
                                    onclick="showTicketModal({
                                        nama_event: '<?php echo addslashes($pesanan['nama_event']); ?>',
                                        waktu_event: '<?php echo addslashes($pesanan['waktu_event']); ?>',
                                        tanggal_event: '<?php echo addslashes($pesanan['tanggal_event']); ?>',
                                        lokasi_event: '<?php echo addslashes($pesanan['lokasi_event']); ?>',
                                        jumlah_tiket: '<?php echo addslashes($pesanan['jumlah_tiket']); ?>',
                                        tanggal_pemesanan: '<?php echo addslashes($pesanan['tanggal_pemesanan']); ?>'
                                    })">Lihat</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada pemesanan tiket yang dilakukan.</p>
        <?php endif; ?>

        <div id="ticketModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeTicketModal()">&times;</span>
                <div class="ticket">
                    <h3 id="ticket-event-name"></h3>
                    <p><strong>Waktu Event :</strong> <span id="ticket-waktu-event"></span></p>
                    <p><strong>Tanggal Event :</strong> <span id="ticket-tanggal-event"></span></p>
                    <p><strong>Lokasi :</strong> <span id="ticket-lokasi-event"></span></p>
                    <p><strong>Jumlah Tiket :</strong> <span id="ticket-jumlah-tiket"></span></p>
                    <p><strong>Tanggal Pemesanan :</strong> <span id="ticket-tanggal-pemesanan"></span></p>
                </div>
            </div>
        </div>
    </div>
    <script src="js/profil.js"></script>
</body>

</html>