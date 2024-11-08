<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$query = "SELECT foto_profil, id_pengguna, nama_lengkap, telp FROM pengguna WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$foto_profil = !empty($user['foto_profil']) ? $user['foto_profil'] : 'assets/default.png';

$id_pengguna = $user['id_pengguna'];

if (isset($_GET['id_event'])) {
    $id_event = $_GET['id_event'];

    $query = "SELECT * FROM events WHERE id_event = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_event);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    } else {
        echo "Event tidak ditemukan.";
        exit();
    }
} else {
    echo "ID event tidak tersedia.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah_tiket = $_POST['ticketQuantity'];

    if ($jumlah_tiket <= $event['kuota_event']) {
        $nama_event = $event['nama_event'];
        $waktu_event = $event['waktu_event'];
        $tanggal_event = $event['tanggal_event'];
        $lokasi_event = $event['lokasi_event'];

        $query = "INSERT INTO data_regis (id_event, id_pengguna, jumlah_tiket, nama_event, waktu_event, tanggal_event, lokasi_event) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiissss", $id_event, $id_pengguna, $jumlah_tiket, $nama_event, $waktu_event, $tanggal_event, $lokasi_event);
        $stmt->execute();

        $new_kuota = $event['kuota_event'] - $jumlah_tiket;
        $query = "UPDATE events SET kuota_event = ? WHERE id_event = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $new_kuota, $id_event);
        $stmt->execute();

        echo "<script>alert('Tiket berhasil dipesan!'); window.location.href='beranda.php';</script>";
    } else {
        echo "<script>alert('Jumlah tiket yang diminta melebihi kuota tersedia.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/beranda.css">
    <link rel="stylesheet" href="styles/landing.css">
    <link rel="stylesheet" href="styles/detail.css">
    <link rel="icon" href="assets/logo.png" />
    <title>Detail Event | EventHub</title>
</head>

<body>
    <nav>
        <div class="nav_logo"><a href="#">EventHub</a></div>
        <div class="nav__profile">
            <img src="<?php echo $foto_profil; ?>" alt="Profile" class="profile__image" onclick="window.location.href='profil.php';">
            <a href="#" class="logout__button" onclick="confirmLogout()">Logout</a>
        </div>
    </nav>

    <section class="event-detail">
        <div class="event-details-container">
            <img src="<?php echo $event['foto_event']; ?>" alt="Event Image" class="event-detail-image">
            <div class="event-info">
                <p><?php echo date('d-m-Y', strtotime($event['tanggal_event'])); ?></p>
                <h1><?php echo htmlspecialchars($event['nama_event']); ?></h1>
                <p class="status"><?php echo htmlspecialchars($event['status_event']); ?></p>
                <p><i class="ri-ticket-2-line"></i> <?php echo htmlspecialchars($event['kuota_event']); ?></p>
                <p>Harga Tiket :
                    <?php
                    if ($event['status_event'] === 'Berbayar') {
                        echo 'Rp ' . number_format($event['harga_tiket'], 0, ',', '.');
                    } else {
                        echo '-';
                    }
                    ?>
                </p>
                <p>Waktu : <?php echo htmlspecialchars($event['waktu_event']); ?></p>
                <p>Lokasi : <?php echo htmlspecialchars($event['lokasi_event']); ?></p><br>
                <p class="des">Deskripsi : </p>
                <p><?php echo htmlspecialchars($event['deskripsi_event']); ?></p>

                <div class="button-container">
                    <button onclick="window.location.href='beranda.php';">Kembali</button>
                    <button onclick="openTicketModal()">Daftar Sekarang</button>
                </div>
            </div>
        </div>
    </section>

    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeTicketModal()">&times;</span>
            <h2>Pesan Tiket</h2>
            <form id="ticketForm" method="POST" action="">
                <input type="hidden" name="event_id" value="<?php echo $id_event; ?>">
                <input type="number" placeholder="Jumlah Tiket" id="ticketQuantity" name="ticketQuantity" min="1" required>
                <div class="modal-buttons">
                    <button type="submit">Pesan Tiket</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div class="section__container" id="kontak">
            <h4>Terhubung dengan kami</h4>
            <div class="social__icons">
                <span><a href="https://www.facebook.com" target="_blank"><i class="ri-facebook-fill"></i></a></span>
                <span><a href="https://twitter.com" target="_blank"><i class="ri-twitter-fill"></i></a></span>
                <span><a href="https://www.instagram.com" target="_blank"><i class="ri-instagram-line"></i></a></span>
            </div>
            <small>&copy; Copyright 2024, EventHub</small>
        </div>
    </footer>
    <script src="js/detail.js"></script>
</body>

</html>