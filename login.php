<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $strDate = sprintf("%06d", $password);

    $year = "20" . substr($strDate, 0, 2);
    $month = substr($strDate, 2, 2);
    $day = substr($strDate, 4, 2);

    $query = "SELECT * FROM `data_siswa` WHERE `nisn` = $username AND `tanggal_lahir` = '$year-$month-$day'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        session_start();
        $_SESSION['nisn'] = $row['nisn'];
        $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
        $_SESSION['foto'] = $row['foto'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Login failed. Please check your username and password.';
    }
}
?>