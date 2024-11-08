<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

$email = $_SESSION['email'];

$query = "SELECT foto_profil, nama_lengkap FROM pengguna WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$foto_profil = !empty($user['foto_profil']) ? $user['foto_profil'] : 'assets/default.png';
$nama_lengkap = $user['nama_lengkap'];

$eventQuery = "SELECT * FROM events";
$eventResult = mysqli_query($conn, $eventQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="styles/beranda.css" />
  <link rel="stylesheet" href="styles/landing.css" />
  <link rel="icon" href="assets/logo.png" />
  <title>Beranda | EventHub</title>
</head>

<body>
  <nav>
    <div class="nav_logo"><a href="#">EventHub</a></div>
    <div class="nav__profile">
      <img src="<?php echo $foto_profil; ?>" alt="Profile" class="profile__image" onclick="window.location.href='profil.php';">
      <a href="#" class="logout__button" onclick="confirmLogout()">Logout</a>
    </div>
  </nav>

  <section class="carousel-container">
    <div class="carousel-images">
      <img src="assets/1.png" alt="Image 1">
      <img src="assets/2.png" alt="Image 2">
    </div>
  </section>

  <section class="welcome-message">
    <h1>Selamat datang,<br><?php echo htmlspecialchars($nama_lengkap); ?>!</h1>
  </section>

  <section class="events-section">
    <div class="search-header">
      <h2>Temukan Event</h2>
      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Cari nama event atau status" onkeyup="liveSearch()">
        <button onclick="liveSearch()">
          <i class="fas fa-search"></i> Cari
        </button>
      </div>
    </div>

    <div class="event-grid" id="eventGrid">
      <?php
      if (mysqli_num_rows($eventResult) > 0) {
        while ($event = mysqli_fetch_assoc($eventResult)) {
          $status = '';
          $currentDate = date('Y-m-d');

          if ($event['tanggal_event'] <= $currentDate) {
            $status = 'selesai';
          } elseif ($event['kuota_event'] <= 0) {
            $status = 'habis';
          } else {
            $status = 'tersedia';
          }

          $cardClass = ($status == 'habis' || $status == 'selesai') ? 'event-card disabled' : 'event-card'; 

          echo '<div class="' . $cardClass . '" onclick="handleCardClick(this, \'' . $event['id_event'] . '\')">';
          echo '<img src="' . $event['foto_event'] . '" alt="' . htmlspecialchars($event['nama_event']) . '" class="event-image">';
          echo '<h3 class="event-name">' . htmlspecialchars($event['nama_event']) . '</h3>';
          echo '<p class="event-status">' . htmlspecialchars($event['status_event']) . '</p>';
          echo '<p class="event-time">' . htmlspecialchars($event['waktu_event']) . '</p>';
          echo '<p class="event-location">' . htmlspecialchars($event['lokasi_event']) . '</p>';

          echo '<div class="event-status-text ' . $status . '">' . ucfirst($status) . '</div>';
          echo '</div>';
        }
      } else {
        echo '<p>Belum ada event yang tersedia.</p>';
      }
      ?>
    </div>
  </section>

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

  <script src="js/beranda.js"></script>
</body>

</html>