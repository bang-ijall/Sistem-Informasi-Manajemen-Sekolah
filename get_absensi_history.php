<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php';

$nisn = $_SESSION['nisn'];

// Ambil data riwayat absensi dari database
$queryHistory = "SELECT * FROM `absensi` WHERE `nisn` = '$nisn' ORDER BY `tanggal` DESC";
$resultHistory = $conn->query($queryHistory);
?>

<!-- Tampilkan riwayat absensi dalam bentuk tabel -->
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Periksa apakah ada riwayat absensi
        if ($resultHistory->num_rows > 0) {
            while ($row = $resultHistory->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['tanggal'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="2">Belum ada riwayat absensi.</td></tr>';
        }
        ?>
    </tbody>
</table>
