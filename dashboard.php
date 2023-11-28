<?php
session_start();

if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php'; // Sesuaikan dengan file konfigurasi database Anda

$nisn = $_SESSION['nisn'];

// Query untuk mengambil data siswa dari database
$query = "SELECT * FROM data_siswa WHERE nisn = '$nisn'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama_lengkap = $row['nama_lengkap'];
    $nik = $row['nik'];
    $email = $row['email'];
    $telepon = $row['no_hp'];
    $jenis_kelamin = $row['kelamin'];
    $tempat_lahir = $row['tempat_lahir'];
    $tanggal_lahir = $row['tanggal_lahir'];
    $agama = $row['agama'];
    $alamat = $row['alamat'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
        }

        nav {
            position: fixed;
            /* Menjadikan navigasi tetap di posisinya */
            top: 0;
            /* Menempatkan navigasi di bagian atas */
            width: 100%;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        nav span {
            margin-right: 10px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        nav div {
            display: flex;
            align-items: center;
        }

        .container {
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: auto;
            border-collapse: collapse;
            margin: auto;
        }

        table,
        th,
        td {
            border: 1px solid;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <nav>
        <a href="dashboard.php">
            <div>
                <img src="assets/lembaga.png" alt="Profile Photo">
                <span>Nama Lembaga</span>
            </div>
        </a>
        <div style="padding-right: 10px;">
            <a href="absensi.php">Absensi</a>
            <a href="rekap_nilai.php">Rekap Nilai</a>
            <a href="jadwal_pelajaran.php">Jadwal Pelajaran</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h2>Biodata siswa</h2>
        <table>
            <tr>
                <th>Nama</th>
                <td><?php echo $nama_lengkap; ?></td>
            </tr>
            <tr>
                <th>NISN</th>
                <td><?php echo $nisn; ?></td>
            </tr>
            <tr>
                <th>NIK</th>
                <td><?php echo $nik; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td><?php echo $telepon; ?></td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td><?php echo $jenis_kelamin; ?></td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td><?php echo $tempat_lahir; ?></td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td><?php echo $tanggal_lahir; ?></td>
            </tr>
            <tr>
                <th>Agama</th>
                <td><?php echo $agama; ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo $alamat; ?></td>
            </tr>
        </table>
    </div>
    <script>

    </script>
</body>

</html>