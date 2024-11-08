<?php
    session_start();
    include 'koneksi.php';

    $regisQuery = "SELECT pengguna.nama_lengkap, pengguna.telp, pengguna.email, 
                data_regis.nama_event, data_regis.jumlah_tiket, data_regis.tanggal_pemesanan 
                FROM data_regis 
                JOIN pengguna ON data_regis.id_pengguna = pengguna.id_pengguna";
    $regisResult = mysqli_query($conn, $regisQuery);


    if (!isset($_SESSION['email']) || $_SESSION['email'] != 'admin@gmail.com') {
        header('Location: login.php');
        exit();
    }

    $query = "SELECT * FROM events";
    $result = mysqli_query($conn, $query);

    $eventToEdit = null;
    $isEditing = false;
    $id_event = '';

    if (isset($_GET['edit'])) {
        $id_event = $_GET['edit'];
        $isEditing = true;

        $editQuery = "SELECT * FROM events WHERE id_event = '$id_event'";
        $editResult = mysqli_query($conn, $editQuery);
        $eventToEdit = mysqli_fetch_assoc($editResult);
    }

    if (isset($_POST['submit'])) {
        $nama_event = $_POST['nama_event'];
        $status_event = $_POST['status_event'];
        $tanggal_event = $_POST['tanggal_event'];
        $waktu_event = $_POST['waktu_event'];
        $lokasi_event = $_POST['lokasi_event'];
        $deskripsi_event = $_POST['deskripsi_event'];
        $harga_tiket = $_POST['harga_tiket'];
        $kuota_event = $_POST['kuota_event'];

        $foto_event = $_FILES['foto_event'];
        $fotoPath = '';

        if ($foto_event['error'] === 0) {
            $uploadDir = 'uploads/event/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fotoPath = $uploadDir . basename($foto_event['name']);
            $allowedExts = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($foto_event['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExtension), $allowedExts)) {
                echo "<script>alert('File harus berupa gambar (JPG, JPEG, PNG)');window.location.href = 'admin.php?section=event';</script>";
                exit();
            }
            if ($foto_event['size'] > 20 * 1024 * 1024) {
                echo "<script>alert('Ukuran file foto terlalu besar. Maksimal ukuran file foto adalah 20 MB.');window.location.href = 'admin.php?section=event';</script>";
                exit();
            }
            if (!move_uploaded_file($foto_event['tmp_name'], $fotoPath)) {
                echo "<script>alert('Gagal mengupload foto.');window.location.href = 'admin.php?section=event';</script>";
                exit();
            }
        } elseif ($isEditing) {
            $fotoPath = $eventToEdit['foto_event'];
        }

        if ($isEditing) {
            $query = "UPDATE events SET foto_event = '$fotoPath', nama_event = '$nama_event', status_event = '$status_event', tanggal_event = '$tanggal_event', waktu_event = '$waktu_event', 
                lokasi_event = '$lokasi_event', deskripsi_event = '$deskripsi_event', harga_tiket = '$harga_tiket', kuota_event = '$kuota_event' WHERE id_event = '$id_event'";
            $message = "Event berhasil diperbarui!";
        } else {
            $tanggal_ditambahkan = date('Y-m-d H:i:s');
            $query = "INSERT INTO events (foto_event, nama_event, status_event, tanggal_event, waktu_event, lokasi_event, deskripsi_event, harga_tiket, kuota_event, tanggal_ditambahkan) VALUES 
                ('$fotoPath', '$nama_event', '$status_event', '$tanggal_event', '$waktu_event', '$lokasi_event', '$deskripsi_event', '$harga_tiket', '$kuota_event', '$tanggal_ditambahkan')";
            $message = "Event berhasil ditambahkan!";
        }

        if (mysqli_query($conn, $query)) {
            echo "<script>
                        alert('$message');
                        window.location.href = 'admin.php?section=event';
                    </script>";
            exit();
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles/admin.css" />
    <link rel="icon" href="assets/logo.png" />
    <title>Admin | EventHub</title>
</head>

<body>
    <div class="sidebar">
        <h2>EventHub</h2>
        <a href="#daftar-registrasi" onclick="showSection('daftar-registrasi')">Daftar Registrasi</a>
        <a href="#event" onclick="showSection('event')">Event</a>
        <a href="#" onclick="confirmLogout()">Logout</a>
    </div>

    <div class="content">
        <div id="daftar-registrasi" class="section active">
            <h3>Daftar Registrasi</h3>

            <div class="search-container">
                <input type="text" id="searchRegistrasiInput" placeholder="Cari nama lengkap, email, atau nama event" onkeyup="liveSearchRegistrasi()">
                <button onclick="liveSearchRegistrasi()">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>

            <table id="registrasiTable" border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Nama Event</th>
                        <th>Jumlah Tiket</th>
                        <th>Tanggal Pemesanan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($regisResult) > 0) {
                        while ($row = mysqli_fetch_assoc($regisResult)) {
                            echo "<tr>";
                            echo "<td class='registrasi-name'>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['telp']) . "</td>";
                            echo "<td class='registrasi-email'>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td class='registrasi-event'>" . htmlspecialchars($row['nama_event']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jumlah_tiket']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_pemesanan']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data registrasi.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="event" class="section">
            <form action="admin.php<?php echo $isEditing ? '?edit=' . $id_event : ''; ?>" method="POST" enctype="multipart/form-data">
                <h3><?php echo $isEditing ? 'Edit Event' : 'Tambah Event Baru'; ?></h3>

                <label for="foto_event">Foto Event :</label>
                <input type="file" id="foto_event" name="foto_event" <?php echo !$isEditing ? 'required' : ''; ?>><br><br>
                <?php if ($isEditing && $eventToEdit['foto_event']) : ?>
                    <img src="<?php echo $eventToEdit['foto_event']; ?>" alt="Current Event Image" width="200" style="display: block; margin-bottom: 10px;"><br>
                <?php endif; ?>

                <label for="nama_event">Nama Event :</label>
                <input type="text" id="nama_event" name="nama_event" value="<?php echo $isEditing ? htmlspecialchars($eventToEdit['nama_event']) : ''; ?>" required><br><br>

                <label for="status_event">Status Event :</label>
                <select id="status_event" name="status_event" required>
                    <option value="" disabled <?php echo !$isEditing ? 'selected' : ''; ?>>Pilih status event</option>
                    <option value="Gratis" <?php echo ($isEditing && strtolower($eventToEdit['status_event']) == 'gratis') ? 'selected' : ''; ?>>Gratis</option>
                    <option value="Berbayar" <?php echo ($isEditing && strtolower($eventToEdit['status_event']) == 'berbayar') ? 'selected' : ''; ?>>Berbayar</option>
                </select><br><br>

                <label for="tanggal_event">Tanggal Event :</label>
                <input type="date" id="tanggal_event" name="tanggal_event" value="<?php echo $isEditing ? htmlspecialchars($eventToEdit['tanggal_event']) : ''; ?>" required><br><br>

                <label for="waktu_event">Waktu Event :</label>
                <input type="text" id="waktu_event" name="waktu_event" placeholder="Contoh: 10.00 - 12.00" value="<?php echo $isEditing ? htmlspecialchars($eventToEdit['waktu_event']) : ''; ?>" required><br><br>

                <label for="lokasi_event">Lokasi Event :</label>
                <input type="text" id="lokasi_event" name="lokasi_event" value="<?php echo $isEditing ? htmlspecialchars($eventToEdit['lokasi_event']) : ''; ?>" required><br><br>

                <label for="deskripsi_event">Deskripsi Event :</label>
                <textarea id="deskripsi_event" name="deskripsi_event" rows="4" required><?php echo $isEditing ? htmlspecialchars($eventToEdit['deskripsi_event']) : ''; ?></textarea><br><br>

                <label for="harga_tiket">Harga Tiket :</label>
                <input type="text" id="harga_tiket" name="harga_tiket" placeholder="Contoh: 100000" value="<?php echo $isEditing ? htmlspecialchars($eventToEdit['harga_tiket']) : ''; ?>" required><br><br>

                <label for="kuota_event">Kuota Event :</label>
                <input type="number" id="kuota_event" name="kuota_event" value="<?php echo $isEditing ? htmlspecialchars($eventToEdit['kuota_event']) : ''; ?>" required><br><br>

                <button type="submit" name="submit"><?php echo $isEditing ? 'Update Event' : 'Buat Event'; ?></button>
            </form>

            <h3>Daftar Event</h3>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Cari nama event atau status" onkeyup="liveSearch()">
                <button onclick="liveSearch()">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>

            <table id="eventTable" border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Event</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td><img src='" . $row['foto_event'] . "' alt='Foto Event' width='100'></td>";
                            echo "<td class='event-name'>" . htmlspecialchars($row['nama_event']) . "</td>";
                            echo "<td class='event-status'>" . htmlspecialchars($row['status_event']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_event']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['waktu_event']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['lokasi_event']) . "</td>";
                            echo "<td>
                                    <div class='action-buttons'>
                                        <a href='admin.php?edit=" . $row['id_event'] . "&section=event' class='action-btn edit-btn'>Edit</a>
                                        <a href='hapus_event.php?id_event=" . $row['id_event'] . "' class='action-btn delete-btn' onclick='return confirm(\"Yakin ingin menghapus event ini?\");'>Hapus</a>
                                    </div>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada event yang ditambahkan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/admin.js"></script>
</body>
</html> 
