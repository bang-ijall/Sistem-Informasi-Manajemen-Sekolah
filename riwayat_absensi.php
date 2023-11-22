<!-- riwayat_absensi.php -->
<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php'; // Sesuaikan dengan nama file konfigurasi database Anda

// Ambil data absensi dari database
$nisn = $_SESSION['nisn'];
$query = "SELECT * FROM `absensi` WHERE `nisn` = '$nisn'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi</title>
    <style>
        /* Gaya CSS sesuai kebutuhan */
    </style>
</head>

<body>
    <h2>Riwayat Absensi</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['tanggal'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>

</html>
