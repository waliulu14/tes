<?php
include('database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Mahasiswa</title>

    <!-- Include Instascan library -->
    <script src="instascan.min.js"></script>
</head>
<body>
    <h1>Halaman Mahasiswa</h1>
    <div>
        <video id="scanner"></video>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Inisialisasi instascan
                let scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });

                // Tangkap hasil pemindaian QR code
                scanner.addListener('scan', function (content) {
                    // Kirim data ke server saat QR code terdeteksi
                    fetch('process_scan.php', {
                        method: 'POST',
                        body: JSON.stringify({ kode_qr_mahasiswa: content }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message); // Tampilkan pesan dari server
                    });
                });

                // Mulai pemindaian
                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function (e) {
                    console.error(e);
                });
            });
        </script>
    </div>
</body>
</html>
