<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php';

$nisn = $_SESSION['nisn'];

// Gantilah query ini sesuai dengan struktur database Anda
$queryRekapNilai = "SELECT pelajaran, nilai FROM data_pelajaran WHERE nisn = '$nisn'";
$resultRekapNilai = $conn->query($queryRekapNilai);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai</title>
    <style>
        /* Tambahkan gaya sesuai kebutuhan untuk halaman rekap nilai */

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

        header {
            background-color: #3498db;
            padding: 10px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            margin: 0;
        }

        #burgerMenu {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            padding: 5px;
        }

        .line {
            width: 20px;
            height: 2px;
            background-color: #fff;
            margin: 4px 0;
            transition: background-color 0.3s;
        }

        #burgerMenu:hover .line {
            background-color: #2980b9;
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

        span {
            margin-right: 10px;
        }

        .profile-image {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }

        main {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        table {
            width: 400px;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ddd;
            text-align: center;
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
    <main>
        <section class="content">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $resultRekapNilai->fetch_assoc()) {
                        // Tampilkan data rekap nilai
                        echo '<tr>';
                        echo '<td>' . $no++ . '</td>';
                        echo '<td>' . $row['pelajaran'] . '</td>';
                        echo '<td>' . $row['nilai'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>