<?php
include('database.php');

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $kode_qr_mahasiswa = $data->kode_qr_mahasiswa;

    try {
        $query = $db->prepare("UPDATE absensi SET status_absen = 1 WHERE kode_qr = :kode_qr_mahasiswa");
        $query->bindParam(':kode_qr_mahasiswa', $kode_qr_mahasiswa);
        $query->execute();

        $pesan = "Absensi berhasil dicatat.";

    } catch (PDOException $e) {
        die("Error updating data in the database: " . $e->getMessage());
    }
}

// Kirim respon JSON ke pemindaian QR code
header('Content-Type: application/json');
echo json_encode(['message' => $pesan]);
?>
