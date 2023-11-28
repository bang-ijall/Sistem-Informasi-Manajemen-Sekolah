<?php
session_start();

// Cek apakah pengguna sudah login atau belum
if (!isset($_SESSION['nisn'])) {
    header('Location: index.html');
    exit();
}

include 'config.php';

$nisn = $_SESSION['nisn'];
$currentDate = date('Y-m-d');

// Periksa apakah pengguna telah melakukan absensi pada hari ini
$queryCheckAbsensi = "SELECT * FROM `absensi` WHERE `nisn` = '$nisn' AND `tanggal` = '$currentDate'";
$resultCheckAbsensi = $conn->query($queryCheckAbsensi);

// Jika sudah melakukan absensi, dapatkan riwayat absensi pada hari itu
if ($resultCheckAbsensi->num_rows > 0) {
    $queryHistory = "SELECT * FROM `absensi` WHERE `nisn` = '$nisn' ORDER BY `tanggal` DESC";
    $resultHistory = $conn->query($queryHistory);
    $hasAbsensi = true;
} else {
    $hasAbsensi = false;
}

$startDate = date('Y-m-d', strtotime('-15 days', strtotime($currentDate)));
$endDate = $currentDate;

$dateRange = [];
$currentDate = $startDate;

while ($currentDate <= $endDate) {
    $dateRange[] = $currentDate;
    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}

// Buat query untuk mengambil status absensi siswa pada tanggal-tanggal tersebut
$queryStatusByDate = "SELECT DISTINCT `tanggal`, COALESCE(`status`, 'Tidak Hadir') as `status` FROM `absensi` WHERE `nisn` = '$nisn' AND `tanggal` BETWEEN '$startDate' AND '$endDate'";

$resultStatusByDate = $conn->query($queryStatusByDate);

// Buat associative array untuk menyimpan status absensi siswa pada setiap tanggal
$statusByDate = [];

while ($row = $resultStatusByDate->fetch_assoc()) {
    $statusByDate[$row['tanggal']] = $row['status'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin: auto;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }

        #info-container {
            display: none;
            background-color: #dff0d8;
            color: #3c763d;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #d6e9c6;
            border-radius: 8px;
            text-align: center;
        }

        #info-container form {
            max-width: 300px;
            margin: auto;
        }

        #info-container h2 {
            color: #5bc0de;
        }

        #info-container label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        #info-container input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        #info-container button {
            background-color: #5bc0de;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        #info-container button:hover {
            background-color: #4cae4c;
        }

        #history-container {
            display: none;
            margin-top: 30px;
        }

        table {
            width: 500px;
            border-collapse: collapse;
            margin: auto;
        }

        th,
        td {
            border: 1px solid #000;
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

    <form action="proses_absensi.php" method="post" id="absensi-form">
        <h2>Absensi Form</h2>

        <!-- Tanggal diisi otomatis dengan tanggal sekarang -->
        <input type="hidden" name="tanggal" value="<?php echo date('Y-m-d'); ?>">

        <button type="button" onclick="submitAbsensi()">Submit Absensi</button>
    </form>

    <div id="info-container">
        <form>
            <h2>Absensi Berhasil</h2>

            <!-- Tampilkan informasi nama, tanggal, dan absensi berhasil -->
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" readonly>

            <label for="tanggal">Tanggal:</label>
            <input type="text" id="tanggal" name="tanggal" readonly>

            <label for="status">Status Absensi:</label>
            <input type="text" id="status" name="status" readonly>

            <!-- Tombol untuk kembali ke halaman absensi jika diperlukan -->
            <button type="button" onclick="backToDashboard()">Kembali ke Dashboard</button>
        </form>
    </div>

    <div id="history-container">
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Tampilkan status absensi siswa pada setiap tanggal
                    foreach ($dateRange as $date) {
                        echo '<tr>';
                        echo '<td>' . $date . '</td>';
                        echo '<td>' . (isset($statusByDate[$date]) ? $statusByDate[$date] : 'Tidak Hadir') . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Panggil fungsi saat halaman telah dimuat
            checkAndDisplayContent();
        });

        function checkAndDisplayContent() {
            var form = document.getElementById("absensi-form");
            var historyContainer = document.getElementById("history-container");

            // Periksa apakah pengguna telah melakukan absensi pada hari ini
            if (<?php echo json_encode($hasAbsensi); ?>) {
                // Jika sudah melakukan absensi, tampilkan riwayat
                form.style.display = "none";
                historyContainer.style.display = "block";
                showAbsensiHistory();
            } else {
                // Jika belum melakukan absensi, tampilkan form absensi
                form.style.display = "block";
                historyContainer.style.display = "none";
            }
        }

        function submitAbsensi() {
            var xhr = new XMLHttpRequest();
            var form = document.getElementById("absensi-form");
            var formData = new FormData(form);

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.error) {
                        showAbsensiError(response.message);
                        showAbsensiHistory();
                    } else {
                        showAbsensiInfo(response);
                        form.style.display = "none";
                        historyContainer.style.display = "block";
                    }
                }
            };

            xhr.open("POST", "proses_absensi.php", true);
            xhr.send(formData);
        }


        function showAbsensiError(message) {
            var infoContainer = document.getElementById("info-container");
            infoContainer.innerHTML = '<h2>Absensi Gagal</h2><p>' + message + '</p>';
            infoContainer.style.display = "block";
        }

        function showAbsensiInfo(message) {
            var infoContainer = document.getElementById("info-container");
            var infoForm = infoContainer.querySelector("form");

            // Isi nilai pada elemen input di dalam form
            infoForm.querySelector("#nama").value = message.nama;
            infoForm.querySelector("#tanggal").value = message.tanggal;
            infoForm.querySelector("#status").value = "Hadir"; // Sesuaikan dengan status yang diinginkan

            // Tampilkan info-container
            infoContainer.style.display = "block";
        }


        function backToDashboard() {
            window.location.href = "absensi.php";
        }
    </script>
</body>

</html>