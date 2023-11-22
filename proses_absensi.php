<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php';

// Ambil data dari formulir
$nisn = $_SESSION['nisn'];
$tanggal = $_POST['tanggal'];
$status = "Hadir"; // Status secara otomatis diatur sebagai "Hadir"

// Validasi data jika diperlukan

// Periksa apakah pengguna sudah melakukan absensi pada tanggal yang sama
$queryCheck = "SELECT * FROM `absensi` WHERE `nisn` = '$nisn' AND `tanggal` = '$tanggal'";
$resultCheck = $conn->query($queryCheck);

if ($resultCheck->num_rows > 0) {
    // Jika sudah ada absensi pada tanggal yang sama, kembalikan pesan error
    $response = array(
        'error' => true,
        'message' => 'Anda telah melakukan absensi pada tanggal ini.'
    );
} else {
    // Jika belum ada absensi pada tanggal yang sama, simpan data absensi baru
    $queryInsert = "INSERT INTO `absensi` (`nisn`, `tanggal`, `status`) VALUES ('$nisn', '$tanggal', '$status')";
    $resultInsert = $conn->query($queryInsert);

    if ($resultInsert) {
        // Jika berhasil, kembalikan respons dalam format JSON
        $response = array(
            'error' => false,
            'nama' => $_SESSION['nama_lengkap'],
            'tanggal' => $tanggal,
            'status' => $status
        );
    } else {
        $response = array(
            'error' => true,
            'message' => 'Gagal menyimpan absensi. Silakan coba lagi.'
        );
    }
}

echo json_encode($response);
$conn->close();
?>