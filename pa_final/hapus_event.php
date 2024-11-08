<?php
    session_start();
    include 'koneksi.php';

    if (!isset($_SESSION['email']) || $_SESSION['email'] != 'admin@gmail.com') {
        header('Location: login.php');
        exit();
    }

    if (isset($_GET['id_event'])) {
        $id_event = $_GET['id_event'];
          
        $query = "SELECT foto_event FROM events WHERE id_event = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_event);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        
        if ($event && file_exists($event['foto_event'])) {
            unlink($event['foto_event']);
        }

        $query = "DELETE FROM events WHERE id_event = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_event);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Event berhasil dihapus!');
                    window.location.href = 'admin.php?section=event';
                </script>";
        } else {
            echo "Terjadi kesalahan: " . $stmt->error;
        }
    } else {
        echo "ID event tidak ditemukan.";
    }

    $stmt->close();
    $conn->close();
?>
