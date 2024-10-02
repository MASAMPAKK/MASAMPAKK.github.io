<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['password'] = $_POST['password'];

    header("Location: index.php");
    exit();
}
?>
