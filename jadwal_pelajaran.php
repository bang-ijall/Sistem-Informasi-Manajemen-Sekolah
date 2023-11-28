<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php';

$nisn = $_SESSION['nisn'];

$queryJadwal = "SELECT * FROM data_pelajaran WHERE nisn = '$nisn' ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')";
$resultJadwal = $conn->query($queryJadwal);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran</title>
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

        main {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        table {
            width: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ddd;
            text-align: center;
        }

        .logout-options {
            display: none;
            position: absolute;
            top: 60px;
            right: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logout-options a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        .logout-options a:hover {
            background-color: #f2f2f2;
        }

        .logout-options.show {
            display: block;
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
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentDay = ''; // Untuk melacak hari saat ini
                    while ($row = $resultJadwal->fetch_assoc()) {
                        // Jika hari berubah, tambahkan baris kosong sebagai pemisah
                        if ($currentDay != $row['hari']) {
                            echo '<tr style="background-color: #ddd;"><td style="text-align: center;" colspan="5"><strong>' . $row['hari'] . '</strong></td></tr>';
                            $currentDay = $row['hari'];
                        }

                        // Tampilkan data jadwal pelajaran
                        echo '<tr>';
                        echo '<td>' . $row['hari'] . '</td>';
                        echo '<td>' . $row['jam'] . '</td>';
                        echo '<td>' . $row['pelajaran'] . '</td>';
                        echo '<td>' . $row['guru'] . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="script.js"></script>
</body>

</html>