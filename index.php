<?php
include('phpqrcode/qrlib.php');
include('database.php');

$kode_qr = uniqid();
QRcode::png($kode_qr, 'qrcodes/'.$kode_qr.'.png');

try {
    $query = $db->prepare("INSERT INTO absensi (kode_qr) VALUES (:kode_qr)");
    $query->bindParam(':kode_qr', $kode_qr);
    $query->execute();
} catch (PDOException $e) {
    die("Error inserting data into the database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dosen</title>
</head>
<body>
    <h1>Halaman Dosen</h1>
    <p>Scan QR Code ini oleh mahasiswa untuk absen:</p>
    <img src="qrcodes/<?php echo $kode_qr; ?>.png" alt="QR Code">
</body>
</html>
