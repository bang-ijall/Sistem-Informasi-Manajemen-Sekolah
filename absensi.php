<!-- absensi.php -->
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
    </style>
</head>

<body>
    <nav>
        <div>
            <img src="assets/lembaga.png" alt="Profile Photo">
            <span>Nama Lembaga</span>
        </div>
        <div>
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

    <script>
        function submitAbsensi() {
            var xhr = new XMLHttpRequest();
            var form = document.getElementById("absensi-form");
            var formData = new FormData(form);

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    showAbsensiInfo(response);

                    // Sembunyikan formulir absensi setelah berhasil
                    form.style.display = "none";
                }
            };

            xhr.open("POST", "proses_absensi.php", true);
            xhr.send(formData);
        }

        function showAbsensiInfo(message) {
    var infoContainer = document.getElementById("info-container");
    var infoForm = infoContainer.querySelector("form");

    if (message.startsWith('Anda telah melakukan absensi')) {
        // Jika pesan error, tampilkan pesan langsung di info-container
        infoContainer.innerHTML = '<h2>Absensi Gagal</h2><p>' + message + '</p>';
    } else {
        // Jika berhasil, lanjutkan seperti biasa
        var data = JSON.parse(message);

        // Isi nilai pada elemen input di dalam form
        infoForm.querySelector("#nama").value = data.nama;
        infoForm.querySelector("#tanggal").value = data.tanggal;
        infoForm.querySelector("#status").value = "Hadir"; // Sesuaikan dengan status yang diinginkan

        // Tampilkan info-container
        infoContainer.style.display = "block";
    }
}


        function backToDashboard() {
            var form = document.getElementById("absensi-form");
            var infoContainer = document.getElementById("info-container");

            // Tampilkan formulir absensi dan sembunyikan info-container
            form.style.display = "block";
            infoContainer.style.display = "none";
        }
    </script>
</body>

</html>